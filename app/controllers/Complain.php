<?php
class Complain extends Controller{

    public function index(){
        $this->view('help/complainReport');
    }

    public function farmerComplaints(){
        $data = [
            'complaints' => [
                (object)[
                    'complain_code' => 'CMP-2024-001',
                    'subject' => 'Service Quality Issue',
                    'description' => 'The service provided was not up to the expected standards.',
                    'category' => 'service',
                    'priority' => 'medium',
                    'status' => 'pending',
                    'incidentDate' => '2024-10-15',
                    'created_at' => '2024-10-15 10:30:00',
                    'fullName' => 'John Doe',
                    'email' => 'john@example.com',
                    'phone' => '0711234567'
                ],
                (object)[
                    'complain_code' => 'CMP-2024-002',
                    'subject' => 'Payment Processing Delay',
                    'description' => 'Payment was delayed for more than a week.',
                    'category' => 'payment',
                    'priority' => 'high',
                    'status' => 'under_review',
                    'incidentDate' => '2024-10-14',
                    'created_at' => '2024-10-14 14:20:00',
                    'fullName' => 'Jane Smith',
                    'email' => 'jane@example.com',
                    'phone' => '0722345678'
                ],
                (object)[
                    'complain_code' => 'CMP-2024-003',
                    'subject' => 'Technical Support Unresponsive',
                    'description' => 'Technical support team did not respond to my queries.',
                    'category' => 'technical',
                    'priority' => 'urgent',
                    'status' => 'pending',
                    'incidentDate' => '2024-10-13',
                    'created_at' => '2024-10-13 09:15:00',
                    'fullName' => 'Bob Johnson',
                    'email' => 'bob@example.com',
                    'phone' => '0733456789'
                ],
                (object)[
                    'complain_code' => 'CMP-2024-004',
                    'subject' => 'Product Quality Concern',
                    'description' => 'Received defective product that does not meet specifications.',
                    'category' => 'product',
                    'priority' => 'medium',
                    'status' => 'resolved',
                    'incidentDate' => '2024-10-12',
                    'created_at' => '2024-10-12 16:45:00',
                    'fullName' => 'Alice Brown',
                    'email' => 'alice@example.com',
                    'phone' => '0744567890'
                ],
                (object)[
                    'complain_code' => 'CMP-2024-005',
                    'subject' => 'Staff Behavior Complaint',
                    'description' => 'Inappropriate behavior from staff member during service.',
                    'category' => 'staff',
                    'priority' => 'high',
                    'status' => 'rejected',
                    'incidentDate' => '2024-10-11',
                    'created_at' => '2024-10-11 11:30:00',
                    'fullName' => 'Charlie Wilson',
                    'email' => 'charlie@example.com',
                    'phone' => '0755678901'
                ]
            ]
        ];
        $this->view('farmer/farmerComplaintsView', $data);
    }

    public function officerComplaints(){
        // Dummy data for officer complaints view
        $data = [
            'complaints' => [
                (object)[
                    'complain_code' => 'CMP-2024-001',
                    'subject' => 'Service Quality Issue',
                    'description' => 'The service provided was not up to the expected standards.',
                    'category' => 'service',
                    'priority' => 'medium',
                    'status' => 'pending',
                    'incidentDate' => '2024-10-15',
                    'created_at' => '2024-10-15 10:30:00',
                    'fullName' => 'John Doe',
                    'email' => 'john@example.com',
                    'phone' => '0711234567'
                ],
                (object)[
                    'complain_code' => 'CMP-2024-002',
                    'subject' => 'Payment Processing Delay',
                    'description' => 'Payment was delayed for more than a week.',
                    'category' => 'payment',
                    'priority' => 'high',
                    'status' => 'under_review',
                    'incidentDate' => '2024-10-14',
                    'created_at' => '2024-10-14 14:20:00',
                    'fullName' => 'Jane Smith',
                    'email' => 'jane@example.com',
                    'phone' => '0722345678'
                ],
                (object)[
                    'complain_code' => 'CMP-2024-003',
                    'subject' => 'Technical Support Unresponsive',
                    'description' => 'Technical support team did not respond to my queries.',
                    'category' => 'technical',
                    'priority' => 'urgent',
                    'status' => 'pending',
                    'incidentDate' => '2024-10-13',
                    'created_at' => '2024-10-13 09:15:00',
                    'fullName' => 'Bob Johnson',
                    'email' => 'bob@example.com',
                    'phone' => '0733456789'
                ],
                (object)[
                    'complain_code' => 'CMP-2024-004',
                    'subject' => 'Product Quality Concern',
                    'description' => 'Received defective product that does not meet specifications.',
                    'category' => 'product',
                    'priority' => 'medium',
                    'status' => 'resolved',
                    'incidentDate' => '2024-10-12',
                    'created_at' => '2024-10-12 16:45:00',
                    'fullName' => 'Alice Brown',
                    'email' => 'alice@example.com',
                    'phone' => '0744567890'
                ],
                (object)[
                    'complain_code' => 'CMP-2024-005',
                    'subject' => 'Staff Behavior Complaint',
                    'description' => 'Inappropriate behavior from staff member during service.',
                    'category' => 'staff',
                    'priority' => 'high',
                    'status' => 'rejected',
                    'incidentDate' => '2024-10-11',
                    'created_at' => '2024-10-11 11:30:00',
                    'fullName' => 'Charlie Wilson',
                    'email' => 'charlie@example.com',
                    'phone' => '0755678901'
                ]
            ]
        ];
        $this->view('officer/officerComplaintsView', $data);
    }

    public function admincomplaints(){
        $this->view('admin/V_complaintslist');
    }
}
?>