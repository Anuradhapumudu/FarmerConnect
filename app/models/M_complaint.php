<?php

/**
 * M_complaint Model
 *
 * Handles all database operations for complaints,
 * officer responses, and related paddy field lookups.
 */
class M_complaint
{
    private Database $db;

    /**
     * Base SELECT used by complaint queries.
     */
    private const COMPLAINT_SELECT = "
        SELECT   cp.*,
                 f.full_name   AS farmer_name,
                 p.Paddy_Size  AS paddySize,
                 o.first_name  AS officer_first_name,
                 o.last_name   AS officer_last_name,
                 o.officer_id  AS updater_id
        FROM     complaints cp
        LEFT JOIN farmers  f ON cp.farmerNIC          = f.nic
        LEFT JOIN paddy    p ON cp.plrNumber          = p.PLR
                             AND cp.farmerNIC         = p.NIC_FK
        LEFT JOIN officers o ON cp.status_updated_by  = o.officer_id
    ";

    public function __construct()
    {
        $this->db = new Database();
    }

    private function notDeleted(string $alias = 'cp'): string
    {
        $col = $alias ? "{$alias}.is_deleted" : 'is_deleted';
        return " AND {$col} = 0";
    }

    private function logError(string $context, Exception $e, mixed $fallback = false): mixed
    {
        error_log("Exception in {$context}: " . $e->getMessage());
        return $fallback;
    }

    /**
     * Inserts a new complaint and returns the generated complaint ID.
     * Returns an error array on failure.
     */
    public function submitComplaint(array $data): string|array
    {
        try {
            $complaintId = isset($data['complaint_id']) && $data['complaint_id'] !== ''
                ? $data['complaint_id']
                : $this->generateComplaintCode();

            $this->db->query("\n                INSERT INTO complaints\n                    (complaint_id, farmerNIC, plrNumber, observationDate,\n                     title, description, media, severity, affectedArea, status, created_at)\n                VALUES\n                    (:complaint_id, :farmerNIC, :plrNumber, :observationDate,\n                     :title, :description, :media, :severity, :affectedArea, :status, NOW())\n            ");

            $this->db->bind(':complaint_id',    $complaintId);
            $this->db->bind(':farmerNIC',       $data['farmerNIC']);
            $this->db->bind(':plrNumber',       $data['plrNumber']);
            $this->db->bind(':observationDate', $data['observationDate']);
            $this->db->bind(':title',           $data['title']);
            $this->db->bind(':description',     $data['description']);
            $this->db->bind(':media',           $data['media']);
            $this->db->bind(':severity',        $data['severity']);
            $this->db->bind(':affectedArea',    $data['affectedArea']);
            $this->db->bind(':status',          $data['status'] ?? 'pending');

            return $this->db->execute() ? $complaintId : ['error' => 'Database execution failed.'];

        } catch (Exception $e) {
            return ['error' => $this->logError('submitComplaint', $e, 'Database error: ' . $e->getMessage())];
        }
    }

    public function getComplaintsByFarmer(string $farmerNIC, bool $includeDeleted = false): array
    {
        try {
            $sql = self::COMPLAINT_SELECT
                 . " WHERE cp.farmerNIC = :farmerNIC"
                 . ($includeDeleted ? '' : $this->notDeleted())
                 . " GROUP BY cp.complaint_id ORDER BY cp.created_at DESC";

            $this->db->query($sql);
            $this->db->bind(':farmerNIC', $farmerNIC);
            return $this->db->resultSet();

        } catch (Exception $e) {
            return $this->logError('getComplaintsByFarmer', $e, []);
        }
    }

    public function getComplaintByCode(string $complaintId, bool $includeDeleted = false): object|false
    {
        try {
            $sql = self::COMPLAINT_SELECT
                 . " WHERE cp.complaint_id = :complaint_id"
                 . ($includeDeleted ? '' : $this->notDeleted());

            $this->db->query($sql);
            $this->db->bind(':complaint_id', $complaintId);
            return $this->db->single();

        } catch (Exception $e) {
            return $this->logError('getComplaintByCode', $e, false);
        }
    }

    public function getAllComplaints(?int $limit = null, ?int $offset = null, bool $includeDeleted = false): array
    {
        try {
            $sql = self::COMPLAINT_SELECT
                 . ($includeDeleted ? ' WHERE 1=1' : ' WHERE cp.is_deleted = 0')
                 . " GROUP BY cp.complaint_id ORDER BY cp.created_at DESC";

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
            return $this->logError('getAllComplaints', $e, []);
        }
    }

    public function searchReports(
        string $farmerNIC = '',
        string $plrNumber = '',
        string $reportCode = '',
        bool $includeDeleted = false
    ): array {
        try {
            $conditions = $includeDeleted ? [] : ['cp.is_deleted = 0'];
            $params = [];

            if (!empty($farmerNIC)) {
                $conditions[] = 'cp.farmerNIC = :farmerNIC';
                $params[':farmerNIC'] = $farmerNIC;
            }

            if (!empty($plrNumber)) {
                $conditions[] = 'cp.plrNumber = :plrNumber';
                $params[':plrNumber'] = $plrNumber;
            }

            if (!empty($reportCode)) {
                $conditions[] = 'cp.complaint_id LIKE :complaintId';
                $params[':complaintId'] = '%' . $reportCode . '%';
            }

            $where = $conditions ? ' WHERE ' . implode(' AND ', $conditions) : '';

            $sql = self::COMPLAINT_SELECT
                 . $where
                 . " GROUP BY cp.complaint_id ORDER BY cp.created_at DESC";

            $this->db->query($sql);
            foreach ($params as $key => $value) {
                $this->db->bind($key, $value);
            }

            return $this->db->resultSet();

        } catch (Exception $e) {
            return $this->logError('searchReports', $e, []);
        }
    }

    public function getPaddyByPLR(string $plr): object|false
    {
        try {
            $this->db->query('SELECT * FROM paddy WHERE PLR = :plr');
            $this->db->bind(':plr', $plr);
            return $this->db->single();

        } catch (Exception $e) {
            return $this->logError('getPaddyByPLR', $e, false);
        }
    }

    public function getPaddyFieldsByFarmer(string $farmerNIC): array
    {
        try {
            $this->db->query('SELECT PLR, Paddy_Size FROM paddy WHERE NIC_FK = :nic ORDER BY PLR ASC');
            $this->db->bind(':nic', $farmerNIC);
            return $this->db->resultSet();

        } catch (Exception $e) {
            return $this->logError('getPaddyFieldsByFarmer', $e, []);
        }
    }

    public function getOfficerResponses(string $complaintId, bool $includeDeleted = false): array
    {
        try {
            $sql = "\n                SELECT   cor.*, o.first_name, o.last_name\n                FROM     complaint_officer_responses cor\n                LEFT JOIN officers o ON cor.officer_id = o.officer_id\n                WHERE    cor.complaint_id = :complaint_id\n            ";

            if (!$includeDeleted) {
                $sql .= ' AND cor.is_deleted = 0';
            }

            $sql .= ' ORDER BY cor.created_at DESC';

            $this->db->query($sql);
            $this->db->bind(':complaint_id', $complaintId);
            return $this->db->resultSet();

        } catch (Exception $e) {
            return $this->logError('getOfficerResponses', $e, []);
        }
    }

    public function getOfficerResponseById(int $id): object|false
    {
        try {
            $this->db->query('SELECT * FROM complaint_officer_responses WHERE id = :id');
            $this->db->bind(':id', $id);
            return $this->db->single();

        } catch (Exception $e) {
            return $this->logError('getOfficerResponseById', $e, false);
        }
    }

    public function updateComplaint(array $data): bool
    {
        try {
            $this->db->query("\n                UPDATE complaints SET\n                    farmerNIC       = :farmerNIC,\n                    plrNumber       = :plrNumber,\n                    observationDate = :observationDate,\n                    title           = :title,\n                    description     = :description,\n                    media           = :media,\n                    severity        = :severity,\n                    affectedArea    = :affectedArea,\n                    is_edited       = 1,\n                    updated_at      = NOW()\n                WHERE complaint_id  = :complaint_id\n            ");

            $this->db->bind(':complaint_id',    $data['complaint_id']);
            $this->db->bind(':farmerNIC',       $data['farmerNIC']);
            $this->db->bind(':plrNumber',       $data['plrNumber']);
            $this->db->bind(':observationDate', $data['observationDate']);
            $this->db->bind(':title',           $data['title']);
            $this->db->bind(':description',     $data['description']);
            $this->db->bind(':media',           $data['media']);
            $this->db->bind(':severity',        $data['severity']);
            $this->db->bind(':affectedArea',    $data['affectedArea']);

            return $this->db->execute();

        } catch (Exception $e) {
            return $this->logError('updateComplaint', $e, false);
        }
    }

    public function updateReportStatus(string $complaintId, string $status, ?string $officerId = null): bool
    {
        try {
            $setClause = $officerId
                ? 'status = :status, status_updated_by = :officer_id, updated_at = NOW()'
                : 'status = :status, updated_at = NOW()';

            $this->db->query("UPDATE complaints SET {$setClause} WHERE complaint_id = :complaint_id");

            $this->db->bind(':status', $status);
            $this->db->bind(':complaint_id', $complaintId);

            if ($officerId) {
                $this->db->bind(':officer_id', $officerId);
            }

            return $this->db->execute();

        } catch (Exception $e) {
            return $this->logError('updateReportStatus', $e, false);
        }
    }

    public function updateOfficerResponse(int $id, string $message, ?string $media = null): bool
    {
        try {
            $mediaClause = $media !== null ? ', response_media = :media' : '';

            $this->db->query("\n                UPDATE complaint_officer_responses\n                SET    response_message = :message,\n                       is_edited        = 1,\n                       updated_at       = NOW()\n                       {$mediaClause}\n                WHERE  id = :id\n            ");

            $this->db->bind(':id', $id);
            $this->db->bind(':message', $message);

            if ($media !== null) {
                $this->db->bind(':media', $media);
            }

            return $this->db->execute();

        } catch (Exception $e) {
            return $this->logError('updateOfficerResponse', $e, false);
        }
    }

    public function deleteComplaint(string $complaintId): bool
    {
        try {
            $this->db->query('UPDATE complaints SET is_deleted = 1 WHERE complaint_id = :complaint_id');
            $this->db->bind(':complaint_id', $complaintId);
            return $this->db->execute();

        } catch (Exception $e) {
            return $this->logError('deleteComplaint', $e, false);
        }
    }

    public function deleteOfficerResponse(int $id): bool
    {
        try {
            $this->db->query('UPDATE complaint_officer_responses SET is_deleted = 1 WHERE id = :id');
            $this->db->bind(':id', $id);
            return $this->db->execute();

        } catch (Exception $e) {
            return $this->logError('deleteOfficerResponse', $e, false);
        }
    }

    public function submitOfficerResponse(
        string $complaintId,
        string $officerId,
        string $message,
        ?string $media = null
    ): bool {
        try {
            $this->db->query("\n                INSERT INTO complaint_officer_responses\n                    (complaint_id, officer_id, response_message, response_media, created_at)\n                VALUES\n                    (:complaint_id, :officer_id, :message, :media, NOW())\n            ");

            $this->db->bind(':complaint_id', $complaintId);
            $this->db->bind(':officer_id', $officerId);
            $this->db->bind(':message', $message);
            $this->db->bind(':media', $media);

            return $this->db->execute();

        } catch (Exception $e) {
            return $this->logError('submitOfficerResponse', $e, false);
        }
    }

    private function generateComplaintCode(): string
    {
        try {
            $this->db->query("\n                SELECT COALESCE(MAX(CAST(SUBSTRING(complaint_id, 3) AS UNSIGNED)), 0) + 1 AS next_id\n                FROM complaints\n            ");
            $result = $this->db->single();
            $nextId = $result->next_id ?? 1;

            return 'CP' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        } catch (Exception $e) {
            error_log('Exception in generateComplaintCode: ' . $e->getMessage());
            return 'CP' . date('His');
        }
    }
}
