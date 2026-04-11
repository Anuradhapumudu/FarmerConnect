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

        if (!$request) return false;

        // 2. Check duplicate PLR
        $this->db->query("SELECT PLR FROM paddy WHERE PLR = :plr");
        $this->db->bind(':plr', $request->PLR);
        if ($this->db->single()) {
            return false;
        }

        // 3. Insert into paddy
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

        // 4. Update request status
        $this->db->query("
            UPDATE paddy_requests
            SET status = 'approved'
            WHERE id = :id
        ");

        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    // Reject request
    public function rejectRequest($id) {
        $this->db->query("
            UPDATE paddy_requests
            SET status = 'rejected'
            WHERE id = :id
        ");

        $this->db->bind(':id', $id);

        return $this->db->execute();
    }
}