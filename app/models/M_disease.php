<?php

/**
 * M_disease Model
 *
 * Handles all database operations for disease reports,
 * officer responses, and related paddy field lookups.
 */
class M_disease
{
    private Database $db;

    // ─── Shared SQL Fragments ──────────────────────────────────────────────────

    /**
     * Base SELECT used by every report query.
     * Joins farmers, paddy, and the officer who last updated status.
     */
    private const REPORT_SELECT = "
        SELECT   dr.*,
                 f.full_name   AS farmer_name,
                 p.Paddy_Size  AS paddySize,
                 o.first_name  AS officer_first_name,
                 o.last_name   AS officer_last_name,
                 o.officer_id  AS updater_id
        FROM     disease_reports dr
        LEFT JOIN farmers  f ON dr.farmerNIC          = f.nic
        LEFT JOIN paddy    p ON dr.plrNumber           = p.PLR
                             AND dr.farmerNIC          = p.NIC_FK
        LEFT JOIN officers o ON dr.status_updated_by  = o.officer_id
    ";

    // ─── Constructor ──────────────────────────────────────────────────────────

    public function __construct()
    {
        $this->db = new Database();
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Returns the SQL fragment that filters out soft-deleted rows.
     * Pass $alias = '' for queries that don't use a table alias.
     */
    private function notDeleted(string $alias = 'dr'): string
    {
        $col = $alias ? "{$alias}.is_deleted" : 'is_deleted';
        return " AND {$col} = 0";
    }

    /**
     * Logs an exception and returns a default fallback value.
     * Keeps catch blocks to a single line.
     */
    private function logError(string $context, Exception $e, mixed $fallback = false): mixed
    {
        error_log("Exception in {$context}: " . $e->getMessage());
        return $fallback;
    }

    // ─── CREATE ───────────────────────────────────────────────────────────────

    /**
     * Inserts a new disease report and returns the generated report code.
     * Returns an error array on failure.
     */
    public function submitDReport(array $data): string|array
    {
        try {
            $reportCode = $this->generateReportCode();

            $this->db->query("
                INSERT INTO disease_reports
                    (report_code, farmerNIC, plrNumber, observationDate,
                     title, description, media, severity, affectedArea, status, created_at)
                VALUES
                    (:report_code, :farmerNIC, :plrNumber, :observationDate,
                     :title, :description, :media, :severity, :affectedArea, :status, NOW())
            ");

            $this->db->bind(':report_code',      $reportCode);
            $this->db->bind(':farmerNIC',         $data['farmerNIC']);
            $this->db->bind(':plrNumber',         $data['plrNumber']);
            $this->db->bind(':observationDate',   $data['observationDate']);
            $this->db->bind(':title',             $data['title']);
            $this->db->bind(':description',       $data['description']);
            $this->db->bind(':media',             $data['media']);
            $this->db->bind(':severity',          $data['severity']);
            $this->db->bind(':affectedArea',      $data['affectedArea']);
            $this->db->bind(':status',            $data['status'] ?? 'pending');

            return $this->db->execute() ? $reportCode : ['error' => 'Database execution failed.'];

        } catch (Exception $e) {
            return ['error' => $this->logError('submitDReport', $e, 'Database error: ' . $e->getMessage())];
        }
    }

    // ─── READ ─────────────────────────────────────────────────────────────────

    /**
     * Returns all reports belonging to a specific farmer.
     */
    public function getReportsByFarmerNIC(string $farmerNIC, bool $includeDeleted = false): array
    {
        try {
            $sql = self::REPORT_SELECT
                 . " WHERE dr.farmerNIC = :farmerNIC"
                 . ($includeDeleted ? '' : $this->notDeleted())
                 . " GROUP BY dr.report_code ORDER BY dr.created_at DESC";

            $this->db->query($sql);
            $this->db->bind(':farmerNIC', $farmerNIC);
            return $this->db->resultSet();

        } catch (Exception $e) {
            return $this->logError('getReportsByFarmerNIC', $e, []);
        }
    }

    /**
     * Returns all reports linked to a specific PLR (paddy land registration) number.
     */
    public function getReportsByPLR(string $plrNumber, bool $includeDeleted = false): array
    {
        try {
            $sql = "SELECT * FROM disease_reports
                    WHERE plrNumber = :plrNumber"
                 . ($includeDeleted ? '' : $this->notDeleted(''))
                 . " ORDER BY created_at DESC";

            $this->db->query($sql);
            $this->db->bind(':plrNumber', $plrNumber);
            return $this->db->resultSet();

        } catch (Exception $e) {
            return $this->logError('getReportsByPLR', $e, []);
        }
    }

    /**
     * Returns a single report by its report code.
     */
    public function getReportByCode(string $reportCode, bool $includeDeleted = false): object|false
    {
        try {
            $sql = self::REPORT_SELECT
                 . " WHERE dr.report_code = :report_code"
                 . ($includeDeleted ? '' : $this->notDeleted());

            $this->db->query($sql);
            $this->db->bind(':report_code', $reportCode);
            return $this->db->single();

        } catch (Exception $e) {
            return $this->logError('getReportByCode', $e, false);
        }
    }

    /**
     * Returns all reports — used by admins and officers.
     * Supports optional pagination via $limit and $offset.
     */
    public function getAllReports(?int $limit = null, ?int $offset = null, bool $includeDeleted = false): array
    {
        try {
            $sql = self::REPORT_SELECT
                 . ($includeDeleted ? ' WHERE 1=1' : ' WHERE dr.is_deleted = 0')
                 . " GROUP BY dr.report_code ORDER BY dr.created_at DESC";

            if ($limit !== null) {
                $sql .= " LIMIT :limit";
                if ($offset !== null) {
                    $sql .= " OFFSET :offset";
                }
            }

            $this->db->query($sql);

            if ($limit !== null) {
                $this->db->bind(':limit', $limit, PDO::PARAM_INT);
                if ($offset !== null) {
                    $this->db->bind(':offset', $offset, PDO::PARAM_INT);
                }
            }

            return $this->db->resultSet();

        } catch (Exception $e) {
            return $this->logError('getAllReports', $e, []);
        }
    }

    /**
     * Searches reports by any combination of farmerNIC, plrNumber, or report code.
     * All parameters are optional — omitting all returns no extra filtering.
     */
    public function searchReports(
        string $farmerNIC     = '',
        string $plrNumber     = '',
        string $reportCode    = '',
        bool   $includeDeleted = false
    ): array {
        try {
            $conditions = $includeDeleted ? [] : ['dr.is_deleted = 0'];
            $params     = [];

            if (!empty($farmerNIC)) {
                $conditions[]         = 'dr.farmerNIC = :farmerNIC';
                $params[':farmerNIC'] = $farmerNIC;
            }

            if (!empty($plrNumber)) {
                $conditions[]          = 'dr.plrNumber = :plrNumber';
                $params[':plrNumber']  = $plrNumber;
            }

            if (!empty($reportCode)) {
                $conditions[]           = 'dr.report_code LIKE :reportCode';
                $params[':reportCode']  = '%' . $reportCode . '%';
            }

            $where = $conditions ? ' WHERE ' . implode(' AND ', $conditions) : '';

            $sql = self::REPORT_SELECT
                 . $where
                 . " GROUP BY dr.report_code ORDER BY dr.created_at DESC";

            $this->db->query($sql);
            foreach ($params as $key => $value) {
                $this->db->bind($key, $value);
            }

            return $this->db->resultSet();

        } catch (Exception $e) {
            return $this->logError('searchReports', $e, []);
        }
    }

    /**
     * Returns the paddy field record for a given PLR number.
     */
    public function getPaddyByPLR(string $plr): object|false
    {
        try {
            $this->db->query("SELECT * FROM paddy WHERE PLR = :plr");
            $this->db->bind(':plr', $plr);
            return $this->db->single();

        } catch (Exception $e) {
            return $this->logError('getPaddyByPLR', $e, false);
        }
    }

    /**
     * Returns all paddy fields (PLR + size) registered to a farmer.
     */
    public function getPaddyFieldsByFarmer(string $farmerNIC): array
    {
        try {
            $this->db->query("SELECT PLR, Paddy_Size FROM paddy WHERE NIC_FK = :nic ORDER BY PLR ASC");
            $this->db->bind(':nic', $farmerNIC);
            return $this->db->resultSet();

        } catch (Exception $e) {
            return $this->logError('getPaddyFieldsByFarmer', $e, []);
        }
    }

    /**
     * Returns all officer responses for a given report code, newest first.
     */
    public function getOfficerResponses(string $reportCode): array
    {
        try {
            $this->db->query("
                SELECT   dor.*, o.first_name, o.last_name
                FROM     disease_officer_responses dor
                LEFT JOIN officers o ON dor.officer_id = o.officer_id
                WHERE    dor.report_code = :report_code
                  AND    dor.is_deleted  = 0
                ORDER BY dor.created_at DESC
            ");
            $this->db->bind(':report_code', $reportCode);
            return $this->db->resultSet();

        } catch (Exception $e) {
            return $this->logError('getOfficerResponses', $e, []);
        }
    }

    /**
     * Returns a single officer response by its primary key ID.
     */
    public function getOfficerResponseById(int $id): object|false
    {
        try {
            $this->db->query("SELECT * FROM disease_officer_responses WHERE id = :id");
            $this->db->bind(':id', $id);
            return $this->db->single();

        } catch (Exception $e) {
            return $this->logError('getOfficerResponseById', $e, false);
        }
    }

    // ─── UPDATE ───────────────────────────────────────────────────────────────

    /**
     * Updates an existing disease report's editable fields.
     */
    public function updateReport(array $data): bool
    {
        try {
            $this->db->query("
                UPDATE disease_reports SET
                    farmerNIC       = :farmerNIC,
                    plrNumber       = :plrNumber,
                    observationDate = :observationDate,
                    title           = :title,
                    description     = :description,
                    media           = :media,
                    severity        = :severity,
                    affectedArea    = :affectedArea,
                    is_edited       = 1,
                    updated_at      = NOW()
                WHERE report_code   = :report_code
            ");

            $this->db->bind(':report_code',      $data['report_code']);
            $this->db->bind(':farmerNIC',         $data['farmerNIC']);
            $this->db->bind(':plrNumber',         $data['plrNumber']);
            $this->db->bind(':observationDate',   $data['observationDate']);
            $this->db->bind(':title',             $data['title']);
            $this->db->bind(':description',       $data['description']);
            $this->db->bind(':media',             $data['media']);
            $this->db->bind(':severity',          $data['severity']);
            $this->db->bind(':affectedArea',      $data['affectedArea']);

            return $this->db->execute();

        } catch (Exception $e) {
            return $this->logError('updateReport', $e, false);
        }
    }

    /**
     * Updates the status of a report, and optionally records which officer changed it.
     */
    public function updateReportStatus(string $reportCode, string $status, ?string $officerId = null): bool
    {
        try {
            $setClause = $officerId
                ? "status = :status, status_updated_by = :officer_id, updated_at = NOW()"
                : "status = :status, updated_at = NOW()";

            $this->db->query("UPDATE disease_reports SET {$setClause} WHERE report_code = :report_code");

            $this->db->bind(':status',       $status);
            $this->db->bind(':report_code',  $reportCode);

            if ($officerId) {
                $this->db->bind(':officer_id', $officerId);
            }

            return $this->db->execute();

        } catch (Exception $e) {
            return $this->logError('updateReportStatus', $e, false);
        }
    }

    /**
     * Updates an officer's response message and, if provided, its media.
     * Passing null for $media leaves the existing media unchanged.
     */
    public function updateOfficerResponse(int $id, string $message, ?string $media = null): bool
    {
        try {
            $mediaClause = $media !== null ? ", response_media = :media" : '';

            $this->db->query("
                UPDATE disease_officer_responses
                SET    response_message = :message,
                       is_edited        = 1,
                       updated_at       = NOW()
                       {$mediaClause}
                WHERE  id = :id
            ");

            $this->db->bind(':id',      $id);
            $this->db->bind(':message', $message);

            if ($media !== null) {
                $this->db->bind(':media', $media);
            }

            return $this->db->execute();

        } catch (Exception $e) {
            return $this->logError('updateOfficerResponse', $e, false);
        }
    }

    // ─── DELETE ───────────────────────────────────────────────────────────────

    /**
     * Soft-deletes a disease report (sets is_deleted = 1).
     */
    public function deleteReport(string $reportCode): bool
    {
        try {
            $this->db->query("UPDATE disease_reports SET is_deleted = 1 WHERE report_code = :report_code");
            $this->db->bind(':report_code', $reportCode);
            return $this->db->execute();

        } catch (Exception $e) {
            return $this->logError('deleteReport', $e, false);
        }
    }

    /**
     * Soft-deletes an officer response (sets is_deleted = 1).
     */
    public function deleteOfficerResponse(int $id): bool
    {
        try {
            $this->db->query("UPDATE disease_officer_responses SET is_deleted = 1 WHERE id = :id");
            $this->db->bind(':id', $id);
            return $this->db->execute();

        } catch (Exception $e) {
            return $this->logError('deleteOfficerResponse', $e, false);
        }
    }

    // ─── Officer Responses: INSERT ────────────────────────────────────────────

    /**
     * Inserts a new officer recommendation/response for a report.
     */
    public function submitOfficerResponse(
        string  $reportCode,
        string  $officerId,
        string  $message,
        ?string $media = null
    ): bool {
        try {
            $this->db->query("
                INSERT INTO disease_officer_responses
                    (report_code, officer_id, response_message, response_media, created_at)
                VALUES
                    (:report_code, :officer_id, :message, :media, NOW())
            ");

            $this->db->bind(':report_code', $reportCode);
            $this->db->bind(':officer_id',  $officerId);
            $this->db->bind(':message',     $message);
            $this->db->bind(':media',       $media);

            return $this->db->execute();

        } catch (Exception $e) {
            return $this->logError('submitOfficerResponse', $e, false);
        }
    }

    // ─── Private Utilities ────────────────────────────────────────────────────

    /**
     * Generates the next sequential report code (e.g. DR001, DR042).
     * Falls back to a timestamp-based code if the DB query fails.
     */
    private function generateReportCode(): string
    {
        try {
            $this->db->query("
                SELECT COALESCE(MAX(CAST(SUBSTRING(report_code, 3) AS UNSIGNED)), 0) + 1 AS next_id
                FROM   disease_reports
            ");
            $result = $this->db->single();
            $nextId = $result->next_id ?? 1;

            return 'DR' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        } catch (Exception $e) {
            error_log("Exception in generateReportCode: " . $e->getMessage());
            return 'DR' . date('His'); // Fallback: timestamp-based (e.g. DR143022)
        }
    }
}