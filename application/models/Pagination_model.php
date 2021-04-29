<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pagination_model extends CI_Model
{

    public function read_list_search_only($table, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and firstname  LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['lname'] != "") {
                $conditions .= ' and lastname  LIKE "%' . $data['lname'] . '%"';
            }
            if ($data['cnic'] != "") {
                $conditions .= ' and cnic LIKE "%' . $data['cnic'] . '%"';
            }
            if ($data['phone'] != "") {
                $conditions .= ' and mobile LIKE "%' . $data['phone'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and patient_id  LIKE "%' . $data['pid'] . '%"';
            }
            if ($data['from_date'] != "") {
                $from_date = "'" . date("Y-m-d", strtotime($data['from_date'])) . "'";
                $conditions .= ' and bill_date  >= ' . $from_date;
            }
            if ($data['to_date'] != "") {
                $to_date = date("Y-m-d", strtotime($data['to_date']));
                $conditions .= ' and bill_date  <= ' . "'" . $to_date . "'";
            }
            if ($data['appointment_id'] != "") {
                $conditions .= ' and appointment_id  LIKE "%' . $data['appointment_id'] . '%"';
            }
            if ($data['appointment_from_date'] != "") {
                $appointment_from_date = "'" . date("Y-m-d", strtotime($data['appointment_from_date'])) . "'";
                $conditions .= ' and create_date  >= ' . $appointment_from_date;
            }
            if ($data['appointment_to_date'] != "") {
                $appointment_to_date = date("Y-m-d", strtotime($data['appointment_to_date']));
                $conditions .= ' and create_date  <= ' . "'" . $appointment_to_date . "'";
            }
            if ($data['prescription_from_date'] != "") {
                $prescription_from_date = "'" . date("Y-m-d", strtotime($data['prescription_from_date'])) . "'";
                $conditions .= ' and date  >= ' . $prescription_from_date;
            }
            if ($data['prescription_to_date'] != "") {
                $prescription_to_date = date("Y-m-d", strtotime($data['prescription_to_date']));
                $conditions .= ' and date  <= ' . "'" . $prescription_to_date . "'";
            }
            if ($data['po_order_no'] != "") {
                $conditions .= ' and po_no  LIKE "%' . $data['po_order_no'] . '%"';
            }
            if ($data['po_from_date'] != "") {
                $po_from_date = "'" . date("Y-m-d", strtotime($data['po_from_date'])) . "'";
                $conditions .= ' and date  >= ' . $po_from_date;
            }
            if ($data['po_to_date'] != "") {
                $po_to_date = date("Y-m-d", strtotime($data['po_to_date']));
                $conditions .= ' and date  <= ' . "'" . $po_to_date . "'";
            }
            if ($data['po_status'] != "") {
                $conditions .= ' and status  LIKE "%' . $data['po_status'] . '%"';
            }
        }

        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

        $sqlStatement = "SELECT * FROM " . $table . " WHERE id<>0 " . $conditions . " ORDER BY id desc";
        return $result = $this->db->query($sqlStatement)->result();
    }

    public function read_patient_list_search($table, $perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and firstname  LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['lname'] != "") {
                $conditions .= ' and lastname  LIKE "%' . $data['lname'] . '%"';
            }
            if ($data['cnic'] != "") {
                $conditions .= ' and cnic LIKE "%' . $data['cnic'] . '%"';
            }
            if ($data['phone'] != "") {
                $conditions .= ' and mobile LIKE "%' . $data['phone'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and patient_id  LIKE "%' . $data['pid'] . '%"';
            }
        }

        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;


        //$sqlStatement = "SELECT * FROM patient WHERE id<>0" . $conditions . " ORDER BY id DESC LIMIT $perpage$page";
        //$sqlStatement = "SELECT * FROM patient p, patient_enquiry e WHERE p.patient_id=e.emr " . $conditions . " ORDER BY e.id desc LIMIT $perpage$page";
        $sqlStatement = "SELECT * FROM patient INNER JOIN (SELECT MAX(id) max_id, emr FROM patient_enquiry GROUP BY emr) p_max ON (patient.patient_id = p_max.emr)" . $conditions . " ORDER BY max_id DESC LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();
    }

    public function read_patient_list_search_count($table, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and firstname  LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['lname'] != "") {
                $conditions .= ' and lastname  LIKE "%' . $data['lname'] . '%"';
            }
            if ($data['cnic'] != "") {
                $conditions .= ' and cnic LIKE "%' . $data['cnic'] . '%"';
            }
            if ($data['phone'] != "") {
                $conditions .= ' and mobile LIKE "%' . $data['phone'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and patient_id  LIKE "%' . $data['pid'] . '%"';
            }/*
            if ($data['from_date'] != "") {
                $from_date = "'" . date("Y-m-d", strtotime($data['from_date'])) . "'";
                $conditions .= ' and bill_date  >= ' . $from_date;
            }*/

        }

        //$sqlStatement = "SELECT * FROM patient WHERE id<> 0" . $conditions;
        //$result = $this->db->query($sqlStatement)->result();
        $sqlStatement = "SELECT * FROM " . $table . " WHERE id<>0 " . $conditions . " ORDER BY id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }

    public function read_bill_list_search($table, $perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and firstname  LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and patient_id  LIKE "%' . $data['pid'] . '%"';
            }
            if ($data['from_date'] != "") {
                $from_date = "'" . date("Y-m-d", strtotime($data['from_date'])) . "'";
                $conditions .= ' and DATE(date)  >= ' . $from_date;
            }
            if ($data['to_date'] != "") {
                $to_date = date("Y-m-d", strtotime($data['to_date']));
                $conditions .= ' and DATE(date)  <= ' . "'" . $to_date . "'";
            }
        }

        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

        $sqlStatement = "SELECT * FROM " . $table . " WHERE id<>0 " . $conditions . " ORDER BY id asc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();
    }

    public function read_bill_list_search_count($table, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and firstname  LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and patient_id  LIKE "%' . $data['pid'] . '%"';
            }
            if ($data['from_date'] != "") {
                $from_date = "'" . date("Y-m-d", strtotime($data['from_date'])) . "'";
                $conditions .= ' and DATE(date)  >= ' . $from_date;
            }
            if ($data['to_date'] != "") {
                $to_date = date("Y-m-d", strtotime($data['to_date']));
                $conditions .= ' and DATE(date)  <= ' . "'" . $to_date . "'";
            }
        }

        $sqlStatement = "SELECT * FROM " . $table . " WHERE id<>0 " . $conditions . " ORDER BY id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }

    public function read_list_search($table, $perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and firstname  LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['lname'] != "") {
                $conditions .= ' and lastname  LIKE "%' . $data['lname'] . '%"';
            }
            if ($data['cnic'] != "") {
                $conditions .= ' and cnic LIKE "%' . $data['cnic'] . '%"';
            }
            if ($data['phone'] != "") {
                $conditions .= ' and mobile LIKE "%' . $data['phone'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and patient_id  LIKE "%' . $data['pid'] . '%"';
            }
            if ($data['from_date'] != "") {
                $from_date = "'" . date("Y-m-d", strtotime($data['from_date'])) . "'";
                $conditions .= ' and bill_date  >= ' . $from_date;
            }
            if ($data['to_date'] != "") {
                $to_date = date("Y-m-d", strtotime($data['to_date']));
                $conditions .= ' and bill_date  <= ' . "'" . $to_date . "'";
            }
            if ($data['appointment_id'] != "") {
                $conditions .= ' and appointment_id  LIKE "%' . $data['appointment_id'] . '%"';
            }
            if ($data['appointment_from_date'] != "") {
                $appointment_from_date = "'" . date("Y-m-d", strtotime($data['appointment_from_date'])) . "'";
                $conditions .= ' and date  >= ' . $appointment_from_date;
            }
            if ($data['appointment_to_date'] != "") {
                $appointment_to_date = date("Y-m-d", strtotime($data['appointment_to_date']));
                $conditions .= ' and date  <= ' . "'" . $appointment_to_date . "'";
            }
            if ($data['prescription_from_date'] != "") {
                $prescription_from_date = "'" . date("Y-m-d", strtotime($data['prescription_from_date'])) . "'";
                $conditions .= ' and date  >= ' . $prescription_from_date;
            }
            if ($data['prescription_to_date'] != "") {
                $prescription_to_date = date("Y-m-d", strtotime($data['prescription_to_date']));
                $conditions .= ' and date  <= ' . "'" . $prescription_to_date . "'";
            }
            if ($data['po_order_no'] != "") {
                $conditions .= ' and po_no  LIKE "%' . $data['po_order_no'] . '%"';
            }
            if ($data['po_from_date'] != "") {
                $po_from_date = "'" . date("Y-m-d", strtotime($data['po_from_date'])) . "'";
                $conditions .= ' and date  >= ' . $po_from_date;
            }
            if ($data['po_to_date'] != "") {
                $po_to_date = date("Y-m-d", strtotime($data['po_to_date']));
                $conditions .= ' and date  <= ' . "'" . $po_to_date . "'";
            }
            if ($data['po_status'] != "") {
                $conditions .= ' and status  LIKE "%' . $data['po_status'] . '%"';
            }
        }

        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

        $sqlStatement = "SELECT * FROM " . $table . " WHERE id<>0 " . $conditions . " ORDER BY id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();
    }

    public function read_list_search_count($table, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and firstname  LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['lname'] != "") {
                $conditions .= ' and lastname  LIKE "%' . $data['lname'] . '%"';
            }
            if ($data['cnic'] != "") {
                $conditions .= ' and cnic LIKE "%' . $data['cnic'] . '%"';
            }
            if ($data['phone'] != "") {
                $conditions .= ' and mobile LIKE "%' . $data['phone'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and patient_id  LIKE "%' . $data['pid'] . '%"';
            }
            if ($data['from_date'] != "") {
                $from_date = "'" . date("Y-m-d", strtotime($data['from_date'])) . "'";
                $conditions .= ' and bill_date  >= ' . $from_date;
            }
            if ($data['to_date'] != "") {
                $to_date = date("Y-m-d", strtotime($data['to_date']));
                $conditions .= ' and bill_date  <= ' . "'" . $to_date . "'";
            }
            if ($data['appointment_id'] != "") {
                $conditions .= ' and appointment_id  LIKE "%' . $data['appointment_id'] . '%"';
            }
            if ($data['appointment_from_date'] != "") {
                $appointment_from_date = "'" . date("Y-m-d", strtotime($data['appointment_from_date'])) . "'";
                $conditions .= ' and date  >= ' . $appointment_from_date;
            }
            if ($data['appointment_to_date'] != "") {
                $appointment_to_date = date("Y-m-d", strtotime($data['appointment_to_date']));
                $conditions .= ' and date  <= ' . "'" . $appointment_to_date . "'";
            }
            if ($data['prescription_from_date'] != "") {
                $prescription_from_date = "'" . date("Y-m-d", strtotime($data['prescription_from_date'])) . "'";
                $conditions .= ' and date  >= ' . $prescription_from_date;
            }
            if ($data['prescription_to_date'] != "") {
                $prescription_to_date = date("Y-m-d", strtotime($data['prescription_to_date']));
                $conditions .= ' and date  <= ' . "'" . $prescription_to_date . "'";
            }
            if ($data['po_order_no'] != "") {
                $conditions .= ' and po_no  LIKE "%' . $data['po_order_no'] . '%"';
            }
            if ($data['po_from_date'] != "") {
                $po_from_date = "'" . date("Y-m-d", strtotime($data['po_from_date'])) . "'";
                $conditions .= ' and date  >= ' . $po_from_date;
            }
            if ($data['po_to_date'] != "") {
                $po_to_date = date("Y-m-d", strtotime($data['po_to_date']));
                $conditions .= ' and date  <= ' . "'" . $po_to_date . "'";
            }
            if ($data['po_status'] != "") {
                $conditions .= ' and status  LIKE "%' . $data['po_status'] . '%"';
            }
        }

        $sqlStatement = "SELECT * FROM " . $table . " WHERE id<>0 " . $conditions . " ORDER BY id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }

    public function read_patient_list_reports($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and firstname LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['lname'] != "") {
                $conditions .= ' and lastname LIKE "%' . $data['lname'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and patient_id LIKE "%' . $data['pid'] . '%"';
            }
            if ($data['from_date'] != "") {
                $conditions .= ' and DATE(created_date) >= "' . $data['from_date'] . '"';
            }
            if ($data['to_date'] != "") {
                $conditions .= ' and DATE(created_date) <= "' . $data['to_date'] . '"';
            }
        }

        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

        $sqlStatement = "SELECT * FROM patient_test INNER JOIN patient ON patient_test.patient_emr = patient.patient_id WHERE patient_test.id<>0 " . $conditions . " GROUP BY patient_test.patient_emr ORDER BY patient_test.id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();
    }

    public function read_patient_list_reports_count($data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and firstname  LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['lname'] != "") {
                $conditions .= ' and lastname  LIKE "%' . $data['lname'] . '%"';
            }
            if ($data['cnic'] != "") {
                $conditions .= ' and cnic LIKE "%' . $data['cnic'] . '%"';
            }
            if ($data['phone'] != "") {
                $conditions .= ' and mobile LIKE "%' . $data['phone'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and patient_id  LIKE "%' . $data['pid'] . '%"';
            }
			if ($data['from_date'] != "") {
                $conditions .= ' and DATE(created_date) >= "' . $data['from_date'] . '"';
            }
            if ($data['to_date'] != "") {
                $conditions .= ' and DATE(created_date) <= "' . $data['to_date'] . '"';
            }
        }

        $sqlStatement = "SELECT * FROM patient_test INNER JOIN patient ON patient_test.patient_emr = patient.patient_id WHERE patient_test.id<>0 " . $conditions . " GROUP BY patient_test.patient_emr ORDER BY patient_test.id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }

    public function read_doctor_patient_list_search($table, $perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and firstname  LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['lname'] != "") {
                $conditions .= ' and lastname  LIKE "%' . $data['lname'] . '%"';
            }
            if ($data['cnic'] != "") {
                $conditions .= ' and cnic LIKE "%' . $data['cnic'] . '%"';
            }
            if ($data['phone'] != "") {
                $conditions .= ' and mobile LIKE "%' . $data['phone'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and patient_id  LIKE "%' . $data['pid'] . '%"';
            }
        }

        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

        $date = '"' . date('Y-m-d 00:00:00') . '"';
        // $sqlStatement = "SELECT * FROM " . $table . " WHERE id<>0 " . $conditions . " ORDER BY id desc LIMIT $perpage$page";

        if ($data['from_date'] != "") {
            $from_date = "'" . date("Y-m-d", strtotime($data['from_date'])) . "'";
            $sqlStatement = "SELECT * FROM patient p, patient_enquiry e  WHERE p.patient_id=e.emr and e.refer_to=" . $this->session->userdata('user_id') . " and DATE(e.record_date) = " . $from_date . " " . $conditions . " ORDER BY e.id asc LIMIT $perpage$page";
        } /*if ($data['doctor_id'] != "")
		{ 
            $from_date = "'" . date("Y-m-d 00:00:00", strtotime($data['from_date'])) . "'";			
			$sqlStatement = "SELECT * FROM patient p, patient_enquiry e  WHERE p.patient_id=e.emr and e.refer_to=" . $data['doctor_id'] . " and e.record_date=" . $date . " " . $conditions . " ORDER BY e.id asc LIMIT $perpage$page"; 
        }
		if (($data['doctor_id'] != "") && ($data['from_date'] != "") )
		{ 
            $from_date = "'" . date("Y-m-d 00:00:00", strtotime($data['from_date'])) . "'";			
			echo $sqlStatement = "SELECT * FROM patient p, patient_enquiry e  WHERE p.patient_id=e.emr and e.refer_to=" . $data['doctor_id'] . " and e.record_date=" . $from_date . " " . $conditions . " ORDER BY e.id asc LIMIT $perpage$page"; 
        }*/
        else {
            $sqlStatement = "SELECT * FROM patient p, patient_enquiry e  WHERE p.patient_id=e.emr and e.refer_to=" . $this->session->userdata('user_id') . " and e.record_date=" . $date . " " . $conditions . " ORDER BY e.id asc LIMIT $perpage$page";
        }
        return $result = $this->db->query($sqlStatement)->result();
    }

    public function read_doctor_patient_list_search_count($table, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and firstname  LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['lname'] != "") {
                $conditions .= ' and lastname  LIKE "%' . $data['lname'] . '%"';
            }
            if ($data['cnic'] != "") {
                $conditions .= ' and cnic LIKE "%' . $data['cnic'] . '%"';
            }
            if ($data['phone'] != "") {
                $conditions .= ' and mobile LIKE "%' . $data['phone'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and patient_id  LIKE "%' . $data['pid'] . '%"';
            }
        }

        $date = '"' . date('Y-m-d 00:00:00') . '"';
        $sqlStatement = "SELECT * FROM patient p, patient_enquiry e  WHERE p.patient_id=e.emr and e.refer_to=" . $this->session->userdata('user_id') . " and e.record_date=" . $date . " " . $conditions . " ORDER BY e.id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }

    public function read_po_list_search($table, $perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['po_order_no'] != "") {
                $conditions .= ' and po_no  LIKE "%' . $data['po_order_no'] . '%"';
            }
            if ($data['po_from_date'] != "") {
                $po_from_date = "'" . date("Y-m-d", strtotime($data['po_from_date'])) . "'";
                $conditions .= ' and purchase_order_date  >= ' . $po_from_date;
            }
            if ($data['po_to_date'] != "") {
                $po_to_date = date("Y-m-d", strtotime($data['po_to_date']));
                $conditions .= ' and purchase_order_date  <= ' . "'" . $po_to_date . "'";
            }
            if ($data['po_status'] != "") {
                $conditions .= ' and status  LIKE "%' . $data['po_status'] . '%"';
            }
        }

        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

        $sqlStatement = "SELECT * FROM " . $table . " WHERE po_no<>0 " . $conditions . " ORDER BY po_no desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();
    }

    public function read_po_list_search_count($table, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['po_order_no'] != "") {
                $conditions .= ' and po_no  LIKE "%' . $data['po_order_no'] . '%"';
            }
            if ($data['po_from_date'] != "") {
                $po_from_date = "'" . date("Y-m-d", strtotime($data['po_from_date'])) . "'";
                $conditions .= ' and purchase_order_date  >= ' . $po_from_date;
            }
            if ($data['po_to_date'] != "") {
                $po_to_date = date("Y-m-d", strtotime($data['po_to_date']));
                $conditions .= ' and purchase_order_date  <= ' . "'" . $po_to_date . "'";
            }
            if ($data['po_status'] != "") {
                $conditions .= ' and status  LIKE "%' . $data['po_status'] . '%"';
            }
        }

        $sqlStatement = "SELECT * FROM " . $table . " WHERE po_no<>0 " . $conditions . " ORDER BY po_no desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }

    public function read_list_search_count_join($data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['dname'] != "") {
                $conditions .= ' and u.firstname  LIKE "%' . $data['dname'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and p.patient_id  LIKE "%' . $data['pid'] . '%"';
            }
            if ($data['apid'] != "") {
                $conditions .= ' and p.appointment_id LIKE "%' . $data['apid'] . '%"';
            }
            if ($data['ptype'] != "") {
                $conditions .= ' and p.patient_type LIKE "%' . $data['ptype'] . '%"';
            }
        }

        $sqlStatement = "SELECT * FROM pr_prescription p , user u  WHERE p.doctor_id=u.user_id and p.doctor_id=" . $this->session->userdata('user_id') . " " . $conditions . " ORDER BY p.id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }

    public function read_doctor_list_search_count_join($data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['dname'] != "") {
                $conditions .= ' and u.firstname  LIKE "%' . $data['dname'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and p.patient_id  LIKE "%' . $data['pid'] . '%"';
            }
            if ($data['apid'] != "") {
                $conditions .= ' and p.appointment_id LIKE "%' . $data['apid'] . '%"';
            }
            if ($data['ptype'] != "") {
                $conditions .= ' and p.patient_type LIKE "%' . $data['ptype'] . '%"';
            }
        }

        $sqlStatement = "SELECT * FROM pr_prescription p , user u  WHERE p.doctor_id=u.user_id " . $conditions . " ORDER BY p.id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }

    public
    function read_alllist_search_count_join($data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and p.firstname  LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['lname'] != "") {
                $conditions .= ' and p.lastname  LIKE "%' . $data['lname'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and p.patient_id  LIKE "%' . $data['pid'] . '%"';
            }
            if ($data['tname'] != "") {
                $conditions .= ' and pt.test_name LIKE "%' . $data['tname'] . '%"';
            }
            if ($data['tstatus'] != "") {
                $conditions .= ' and pt.status LIKE "%' . $data['tstatus'] . '%"';
            }
            if ($data['from_date'] != "") {
                $from_date = "'" . date("Y-m-d", strtotime($data['from_date'])) . "'";
                $conditions .= ' and pt.updated_date  >= ' . $from_date;
            }
            if ($data['to_date'] != "") {
                $to_date = date("Y-m-d", strtotime($data['to_date']));
                $conditions .= ' and pt.updated_date  <= ' . "'" . $to_date . "'";
            }
        }

        $sqlStatement = "SELECT *,pt.status as tstatus,pt.id as tid FROM patient_test pt , patient p  WHERE pt.patient_emr=p.patient_id  and (pt.status='Generated' or pt.status='received' or pt.status='Approved')" . $conditions . " ORDER BY pt.id desc";

        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }

    public
    function read_alllist_search_join($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and p.firstname  LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['lname'] != "") {
                $conditions .= ' and p.lastname  LIKE "%' . $data['lname'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and p.patient_id  LIKE "%' . $data['pid'] . '%"';
            }
            if ($data['tname'] != "") {
                $conditions .= ' and pt.test_name LIKE "%' . $data['tname'] . '%"';
            }
            if ($data['tstatus'] != "") {
                $conditions .= ' and pt.status LIKE "%' . $data['tstatus'] . '%"';
            }
            if ($data['from_date'] != "") {
                $from_date = "'" . date("Y-m-d", strtotime($data['from_date'])) . " 00:00:00'";
                $conditions .= ' and pt.updated_date  >= ' . $from_date;
            }
            if ($data['to_date'] != "") {
                $to_date = date("Y-m-d", strtotime($data['to_date']));
                $conditions .= ' and pt.updated_date  <= ' . "'" . $to_date . " 23:59:59'";
            }

        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

        $sqlStatement = "SELECT *,pt.status as tstatus,pt.id as tid FROM patient_test pt , patient p  WHERE pt.patient_emr=p.patient_id  and (pt.status='Generated' or pt.status='received' or pt.status='Approved')" . $conditions . " ORDER BY pt.id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }

/////////////////////////////////////////////
    public
    function read_list_search_nurse($perpage, $page)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and p.firstname  LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['lname'] != "") {
                $conditions .= ' and p.lastname  LIKE "%' . $data['lname'] . '%"';
            }
            if ($data['cnic'] != "") {
                $conditions .= ' and p.cnic LIKE "%' . $data['cnic'] . '%"';
            }
            if ($data['phone'] != "") {
                $conditions .= ' and p.mobile LIKE "%' . $data['phone'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and p.patient_id  LIKE "%' . $data['pid'] . '%"';
            }

        }

        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

        if ($this->session->userdata('search_patient')['from_date'] != null) {
            $date = '"' . date('Y-m-d', strtotime($this->session->userdata('search_patient')['from_date'])) . ' 00:00:00"';
        } else {
            $date = '"' . date('Y-m-d 00:00:00') . '"';
        }
        $sqlStatement = "SELECT * FROM patient p, patient_enquiry e  WHERE p.patient_id=e.emr and e.refer_to !=0 and e.record_date=" . $date . " " . $conditions . " ORDER BY e.id asc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();
    }

    public
    function read_list_search_nurse_count()
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['fname'] != "") {
                $conditions .= ' and p.firstname  LIKE "%' . $data['fname'] . '%"';
            }
            if ($data['lname'] != "") {
                $conditions .= ' and p.lastname  LIKE "%' . $data['lname'] . '%"';
            }
            if ($data['cnic'] != "") {
                $conditions .= ' and p.cnic LIKE "%' . $data['cnic'] . '%"';
            }
            if ($data['phone'] != "") {
                $conditions .= ' and p.mobile LIKE "%' . $data['phone'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and p.patient_id  LIKE "%' . $data['pid'] . '%"';
            }
        }

        /* if ($page == 0)
             $page = '';
         else
             $page = ' OFFSET ' . $page;*/

        if ($this->session->userdata('search_patient')['from_date'] != null) {
            $date = '"' . date('Y-m-d', strtotime($this->session->userdata('search_patient')['from_date'])) . ' 00:00:00"';
        } else {
            $date = '"' . date('Y-m-d 00:00:00') . '"';
        }
        $sqlStatement = "SELECT * FROM patient p, patient_enquiry e WHERE p.patient_id=e.emr and e.record_date=" . $date . " " . $conditions . " ORDER BY e.id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }

////////////////////////////////////////////	
    public
    function read_list_search_join($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['dname'] != "") {
                $conditions .= ' and u.firstname  LIKE "%' . $data['dname'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and p.patient_id  LIKE "%' . $data['pid'] . '%"';
            }
            if ($data['apid'] != "") {
                $conditions .= ' and p.appointment_id LIKE "%' . $data['apid'] . '%"';
            }
            if ($data['ptype'] != "") {
                $conditions .= ' and p.patient_type LIKE "%' . $data['ptype'] . '%"';
            }

        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

        $sqlStatement = "SELECT * FROM pr_prescription p , user u  WHERE p.doctor_id=u.user_id and p.doctor_id=" . $this->session->userdata('user_id') . " " . $conditions . " ORDER BY p.id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }

    public
    function read_doctor_list_search_join($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['dname'] != "") {
                $conditions .= ' and u.firstname  LIKE "%' . $data['dname'] . '%"';
            }
            if ($data['pid'] != "") {
                $conditions .= ' and p.patient_id  LIKE "%' . $data['pid'] . '%"';
            }
            if ($data['apid'] != "") {
                $conditions .= ' and p.appointment_id LIKE "%' . $data['apid'] . '%"';
            }
            if ($data['ptype'] != "") {
                $conditions .= ' and p.patient_type LIKE "%' . $data['ptype'] . '%"';
            }

        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

        $sqlStatement = "SELECT * FROM pr_prescription p , user u  WHERE p.doctor_id=u.user_id " . $conditions . " ORDER BY p.id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }
	
	function read_member_list_count($table, $data)
    { 
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['emp_comp_id'] != "--Select company--") {
                $conditions .= ' and emp_company_id ="' . $data['emp_comp_id'] . '"';
            }
            if ($data['emp_name'] != "") {
				
                $conditions .= ' and emp_name  LIKE "%' . $data['emp_name'] . '%"';
            }
        }

       
 		$sqlStatement = "SELECT * FROM members m, companies c WHERE c.comp_id = m.emp_company_id   " . $conditions . " AND emp_status!=1 AND emp_is_deleted!=1 ORDER BY m.id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }
	
	function read_member_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['emp_comp_id'] != "--Select company--") {
                $conditions .= ' and emp_company_id ="' . $data['emp_comp_id'] . '"';
            }
            if ($data['emp_name'] != "") {
                $conditions .= ' and emp_name  LIKE "%' . $data['emp_name'] . '%"';
            }
            
        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

  		$sqlStatement = "SELECT * FROM members m, companies c WHERE c.comp_id = m.emp_company_id  " . $conditions . "  AND emp_status!=1 AND emp_is_deleted!=1 ORDER BY m.id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }
	
	function read_doctor_list_count($table, $data)
    { 
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['dr_comp_id'] != "--Select company--") {
                $conditions .= ' and dr_company_id ="' . $data['dr_comp_id'] . '"';
            } 
            if ($data['dr_doctor_name'] != "") {
				
                $conditions .= ' and dr_doctor_name  LIKE "%' . $data['dr_doctor_name'] . '%"';
            }
        }
       
 		$sqlStatement = "SELECT * FROM doctors d, companies c WHERE c.comp_id = d.dr_company_id  " . $conditions . "  AND dr_status!=1 AND dr_is_deleted!=1 ORDER BY d.id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
		
    }
	
	function read_doctor_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['dr_comp_id'] != "--Select company--") {
                $conditions .= ' and dr_company_id ="' . $data['dr_comp_id'] . '"';
            }
            if ($data['dr_doctor_name'] != "") {
                $conditions .= ' and dr_doctor_name  LIKE "%' . $data['dr_doctor_name'] . '%"';
            }
            
        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

  		$sqlStatement = "SELECT * FROM doctors d, companies c WHERE c.comp_id = d.dr_company_id  " . $conditions . "  AND dr_status!=1 AND dr_is_deleted!=1 ORDER BY d.id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }
	
	function read_pharmacy_list_count($table, $data)
    { 
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['pharm_comp_id'] != "--Select company--") {
                $conditions .= ' and pharm_company_id ="' . $data['pharm_comp_id'] . '"';
            }
            if ($data['pharm_pharmacy_name'] != "") {
				
                $conditions .= ' and pharm_pharmacy_name  LIKE "%' . $data['pharm_pharmacy_name'] . '%"';
            }
        }

       
 		$sqlStatement = "SELECT * FROM pharmacy p, companies c WHERE c.comp_id = p.pharm_company_id  " . $conditions . " AND pharm_status!=1 AND pharm_is_deleted!=1 ORDER BY p.id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }
	
	function read_pharmacy_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['pharm_comp_id'] != "--Select company--") {
                $conditions .= ' and pharm_company_id ="' . $data['pharm_comp_id'] . '"';
            }
            if ($data['pharm_pharmacy_name'] != "") {
                $conditions .= ' and pharm_pharmacy_name  LIKE "%' . $data['pharm_pharmacy_name'] . '%"';
            }
            
        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

  		$sqlStatement = "SELECT * FROM pharmacy p, companies c WHERE c.comp_id = p.pharm_company_id  " . $conditions . " AND pharm_status!=1 AND pharm_is_deleted!=1 ORDER BY p.id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }
	
	function read_wholesaler_list_count($table, $data)
    { 
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['wholesaler_comp_id'] != "--Select company--") {
                $conditions .= ' and wholesaler_company_id ="' . $data['wholesaler_comp_id'] . '"';
            }
            if ($data['wholesaler_name'] != "") {
				
                $conditions .= ' and wholesaler_name  LIKE "%' . $data['wholesaler_name'] . '%"';
            }
        }

       
 		$sqlStatement = "SELECT * FROM wholesaler w, companies c WHERE c.comp_id = w.wholesaler_company_id  " . $conditions . " AND wholesaler_status!=1 AND wholesaler_is_deleted!=1  ORDER BY w.id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }
	
	function read_wholesaler_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['wholesaler_comp_id'] != "--Select company--") {
                $conditions .= ' and wholesaler_company_id ="' . $data['wholesaler_comp_id'] . '"';
            }
            if ($data['wholesaler_name'] != "") {
                $conditions .= ' and wholesaler_name  LIKE "%' . $data['wholesaler_name'] . '%"';
            }
            
        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

  		$sqlStatement = "SELECT * FROM wholesaler w, companies c WHERE c.comp_id = w.wholesaler_company_id  " . $conditions . " AND wholesaler_status!=1 AND wholesaler_is_deleted!=1  ORDER BY w.id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }
	
	
	
	function read_dosageform_list_count($table, $data)
    { 
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['dosageform_name'] != "") {
				
                $conditions .= ' and df_name  LIKE "%' . $data['dosageform_name'] . '%"';
            }
        }

       
 		$sqlStatement = "SELECT * FROM dosage_form WHERE df_id<>0  " . $conditions . " ORDER BY df_id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }
	
	function read_dosageform_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['dosageform_name'] != "") {
                $conditions .= ' and df_name  LIKE "%' . $data['dosageform_name'] . '%"';
            }
            
        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

  		$sqlStatement = "SELECT * FROM dosage_form WHERE df_id<>0  " . $conditions . " ORDER BY df_id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }
	
	function read_dosage_list_count($table, $data)
    { 
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['dosage_name'] != "") {
				
                $conditions .= ' and dosage_name  LIKE "%' . $data['dosage_name'] . '%"';
            }
        }

       
 		$sqlStatement = "SELECT * FROM dosage WHERE dosage_id<>0  " . $conditions . " ORDER BY dosage_id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }
	
	function read_dosage_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['dosage_name'] != "") {
                $conditions .= ' and dosage_name  LIKE "%' . $data['dosage_name'] . '%"';
            }
            
        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

  		$sqlStatement = "SELECT * FROM dosage WHERE dosage_id<>0  " . $conditions . " ORDER BY dosage_id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }
	
	function read_speciality_list_count($table, $data)
    { 
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['sp_name'] != "") {
				
                $conditions .= ' and sp_name  LIKE "%' . $data['sp_name'] . '%"';
            }
        }

       
 		$sqlStatement = "SELECT * FROM speciality WHERE sp_id<>0  " . $conditions . " ORDER BY sp_id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }
	
	function read_speciality_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['sp_name'] != "") {
                $conditions .= ' and sp_name  LIKE "%' . $data['sp_name'] . '%"';
            }
            
        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

  		$sqlStatement = "SELECT * FROM speciality WHERE sp_id<>0  " . $conditions . " ORDER BY sp_id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }
	
	function read_class_list_count($table, $data)
    { 
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['cl_name'] != "") {
				
                $conditions .= ' and cl_name  LIKE "%' . $data['cl_name'] . '%"';
            }
        }

       
 		$sqlStatement = "SELECT * FROM classes WHERE cl_id<>0  " . $conditions . " ORDER BY cl_id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }
	
	function read_class_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['cl_name'] != "") {
                $conditions .= ' and cl_name  LIKE "%' . $data['cl_name'] . '%"';
            }
            
        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

  		$sqlStatement = "SELECT * FROM classes WHERE cl_id<>0  " . $conditions . " ORDER BY cl_id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }
	
	function read_segment_list_count($table, $data)
    { 
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['cl_name'] != "") {
				
                $conditions .= ' and cl_name  LIKE "%' . $data['cl_name'] . '%"';
            }
        }

       
 		$sqlStatement = "SELECT * FROM segment WHERE seg_id<>0  " . $conditions . " ORDER BY seg_id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }
	
	function read_segment_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['seg_name'] != "") {
                $conditions .= ' and seg_name  LIKE "%' . $data['seg_name'] . '%"';
            }
            
        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

  		$sqlStatement = "SELECT * FROM segment WHERE seg_id<>0  " . $conditions . " ORDER BY seg_id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }
	function read_workinghour_list_count($table, $data)
    { 
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['wh_name'] != "") {
				
                $conditions .= ' and wh_name  LIKE "%' . $data['wh_name'] . '%"';
            }
        }

       
 		$sqlStatement = "SELECT * FROM working_hours WHERE wh_id<>0  " . $conditions . " ORDER BY wh_id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }
	
	function read_workinghour_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['wh_name'] != "") {
                $conditions .= ' and wh_name  LIKE "%' . $data['wh_name'] . '%"';
            }
            
        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

  		$sqlStatement = "SELECT * FROM working_hours WHERE wh_id<>0  " . $conditions . " ORDER BY wh_id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }
	function read_groups_list_count($table, $data)
    { 
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['group_comp_id'] != "--Select company--") {
                $conditions .= ' and group_company_id =' . $data['group_comp_id'] . '';
            }
            if ($data['group_name'] != "") {
				
                $conditions .= ' and group_name  LIKE "%' . $data['group_name'] . '%"';
            }
        }

       
 		$sqlStatement = "SELECT * FROM groups g, companies c WHERE c.comp_id = g.group_company_id  " . $conditions . " AND group_status!=1 AND group_is_deleted!=1 ORDER BY g.id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }
	
	function read_groups_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['group_comp_id'] != "--Select company--") {
                $conditions .= ' and group_company_id =' . $data['group_comp_id'] . '';
            }
            if ($data['group_name'] != "") {
                $conditions .= ' and group_name  LIKE "%' . $data['group_name'] . '%"';
            }
            
        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

  		$sqlStatement = "SELECT * FROM groups g, companies c WHERE c.comp_id = g.group_company_id " . $conditions . " AND group_status!=1 AND group_is_deleted!=1 ORDER BY g.id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }
	
	function read_product_list_count($table, $data)
    { 
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['product_comp_id'] != "--Select company--") {
                $conditions .= ' and product_company_id =' . $data['product_comp_id'] . '';
            }            
            if ($data['product_name'] != "") {
				
                $conditions .= ' and product_name  LIKE "%' . $data['product_name'] . '%"';
            }
        }
 		$sqlStatement = "SELECT * FROM products p, companies c WHERE c.comp_id = p.product_company_id  " . $conditions . " AND product_status!=1 AND product_is_deleted!=1 ORDER BY p.id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }
	
	function read_product_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
            if ($data['product_comp_id'] != "--Select company--") {
                $conditions .= ' and product_company_id ="' . $data['product_comp_id'] . '"';
            }            
            if ($data['product_name'] != "") {
				
                $conditions .= ' and product_name  LIKE "%' . $data['product_name'] . '%"';
            }
            
        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

  		$sqlStatement = "SELECT * FROM products p, companies c WHERE c.comp_id = p.product_company_id  " . $conditions . " AND product_status!=1 AND product_is_deleted!=1 ORDER BY p.id desc LIMIT $perpage$page";
		
        return $result = $this->db->query($sqlStatement)->result();

    }
	
	function read_competition_list_count($table, $data)
    { 
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['competition_comp_id'] != "--Select company--") {
                $conditions .= ' and competition_company_id ="' . $data['competition_comp_id'] . '"';
            }   
            if ($data['competition_product_name'] != "") {
				
                $conditions .= ' and competition_product_name  LIKE "%' . $data['competition_product_name'] . '%"';
            }
        }

       
 		$sqlStatement = "SELECT * FROM competition c, companies com WHERE com.comp_id = c.competition_company_id  " . $conditions . " AND competition_status!=1 AND competition_is_deleted!=1 ORDER BY c.competition_id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }
	
	function read_competition_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['competition_comp_id'] != "--Select company--") {
                $conditions .= ' and competition_company_id ="' . $data['competition_comp_id'] . '"';
            } 
            if ($data['competition_product_name'] != "") {
                $conditions .= ' and competition_product_name  LIKE "%' . $data['competition_product_name'] . '%"';
            }
            
        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

  		$sqlStatement = "SELECT * FROM competition c, companies com WHERE com.comp_id = c.competition_company_id  " . $conditions . " AND competition_status!=1 AND competition_is_deleted!=1 ORDER BY c.competition_id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }
	
	function read_visit_list_count($table, $data)
    { 
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['visit_comp_id'] != "--Select company--") {
                $conditions .= ' and visit_company_id ="' . $data['visit_comp_id'] . '"';
            }   
            if ($data['emp_name'] != "") {
				
                $conditions .= ' and emp_name  LIKE "%' . $data['emp_name'] . '%"';
            }
        }

       
 		$sqlStatement = "SELECT * FROM visit_planner vp, companies com WHERE com.comp_id = c.competition_company_id  " . $conditions . " AND competition_status!=1 AND competition_is_deleted!=1 ORDER BY c.competition_id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }
	
	function read_visit_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
			if ($data['competition_comp_id'] != "--Select company--") {
                $conditions .= ' and competition_company_id ="' . $data['competition_comp_id'] . '"';
            } 
            if ($data['competition_product_name'] != "") {
                $conditions .= ' and competition_product_name  LIKE "%' . $data['competition_product_name'] . '%"';
            }
            
        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;

  		$sqlStatement = "SELECT * FROM competition c, companies com WHERE com.comp_id = c.competition_company_id  " . $conditions . " AND competition_status!=1 AND competition_is_deleted!=1 ORDER BY c.competition_id desc LIMIT $perpage$page";
        return $result = $this->db->query($sqlStatement)->result();

    }
}