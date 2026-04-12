<?php

class plrReqModel {

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get all requests by division
    public function getPendingRequests($division) {
        $this->db->query("
            SELECT pr.*, f.full_name
            FROM paddy_requests pr
            JOIN farmers f ON pr.NIC_FK = f.nic
            WHERE pr.Govi_Jana_Sewa_Division = :division
            AND pr.status = 'pending'
            ORDER BY pr.created_at DESC
        ");

        $this->db->bind(':division', $division);
        return $this->db->resultSet();
    }

    public function getHistoryRequests($division) {
    $this->db->query("
        SELECT pr.*, f.full_name
        FROM paddy_requests pr
        JOIN farmers f ON pr.NIC_FK = f.nic
        WHERE pr.Govi_Jana_Sewa_Division = :division
        AND pr.status != 'pending'
        ORDER BY pr.created_at DESC
    ");

    $this->db->bind(':division', $division);
    return $this->db->resultSet();
}

//  SEARCH PENDING
public function searchPending($division, $search) {

    $this->db->query("
        SELECT pr.*, f.full_name
        FROM paddy_requests pr
        JOIN farmers f ON pr.NIC_FK = f.nic
        WHERE pr.Govi_Jana_Sewa_Division = :division
        AND pr.status = 'pending'
        AND (pr.PLR LIKE :search OR pr.NIC_FK LIKE :search)
        ORDER BY pr.created_at DESC
    ");

    $this->db->bind(':division', $division);
    $this->db->bind(':search', '%' . $search . '%');

    return $this->db->resultSet();
}


//  SEARCH HISTORY
public function searchHistory($division, $search) {

    $this->db->query("
        SELECT pr.*, f.full_name
        FROM paddy_requests pr
        JOIN farmers f ON pr.NIC_FK = f.nic
        WHERE pr.Govi_Jana_Sewa_Division = :division
        AND pr.status != 'pending'
        AND (pr.PLR LIKE :search OR pr.NIC_FK LIKE :search)
        ORDER BY pr.created_at DESC
    ");

    $this->db->bind(':division', $division);
    $this->db->bind(':search', '%' . $search . '%');

    return $this->db->resultSet();
}

    // Get single request
    public function getRequestById($id) {
        $this->db->query("
            SELECT pr.*, f.full_name
            FROM paddy_requests pr
            JOIN farmers f ON pr.NIC_FK = f.nic
            WHERE pr.id = :id
        ");

        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    // Approve request
    public function approveRequest($id) {

        // 1. Get request
        $this->db->query("SELECT * FROM paddy_requests WHERE id = :id");
        $this->db->bind(':id', $id);
        $request = $this->db->single();

        if (!$request) return ['status' => false];

        // 2. Check if PLR already exists
        $this->db->query("
            SELECT p.NIC_FK, f.full_name
            FROM paddy p
            JOIN farmers f ON p.NIC_FK = f.nic
            WHERE p.PLR = :plr
        ");

        $this->db->bind(':plr', $request->PLR);
        $existing = $this->db->single();

        // ❌ IF EXISTS → RETURN ERROR
        if ($existing) {
            return [
                'status' => 'exists',
                'nic' => $existing->NIC_FK,
                'name' => $existing->full_name
            ];
        }

        // 3. Insert to paddy
        $this->db->query("
            INSERT INTO paddy 
            (PLR, NIC_FK, OfficerID, Paddy_Seed_Variety, Paddy_Size, Province, District, Govi_Jana_Sewa_Division, Grama_Niladhari_Division, Yaya)
            VALUES
            (:PLR, :NIC, :OfficerID, :Seed, :Size, :Province, :District, :Division, :GN, :Yaya)
        ");

        $this->db->bind(':PLR', $request->PLR);
        $this->db->bind(':NIC', $request->NIC_FK);
        $this->db->bind(':OfficerID', $_SESSION['officer_id']);
        $this->db->bind(':Seed', $request->Paddy_Seed_Variety);
        $this->db->bind(':Size', $request->Paddy_Size);
        $this->db->bind(':Province', $request->Province);
        $this->db->bind(':District', $request->District);
        $this->db->bind(':Division', $request->Govi_Jana_Sewa_Division);
        $this->db->bind(':GN', $request->Grama_Niladhari_Division);
        $this->db->bind(':Yaya', $request->Yaya);

        $this->db->execute();

        // 4. Update status
        $this->db->query("
            UPDATE paddy_requests
            SET status = 'approved'
            WHERE id = :id
        ");
        $this->db->bind(':id', $id);
        $this->db->execute();

        return ['status' => 'success'];
    }

    // Reject request
    public function rejectRequest($id) {

        // 1. Get request
        $this->db->query("SELECT * FROM paddy_requests WHERE id = :id");
        $this->db->bind(':id', $id);
        $request = $this->db->single();

        if (!$request) return false;

        // 2. ❌ DELETE from paddy if exists
        $this->db->query("DELETE FROM paddy WHERE PLR = :plr");
        $this->db->bind(':plr', $request->PLR);
        $this->db->execute();

        // 3. Update request status
        $this->db->query("
            UPDATE paddy_requests
            SET status = 'rejected'
            WHERE id = :id
        ");

        $this->db->bind(':id', $id);

        return $this->db->execute();
}
}