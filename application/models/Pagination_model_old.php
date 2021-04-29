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
	
	public function read_member_list_count()
    {
        if ($data == null) {
            $conditions = '';
        } else {
            
        }
       
       $conditions = 'where emp_is_deleted!=1';
        
        $sqlStatement = "SELECT * FROM members " . $conditions . " ORDER BY id desc";
        $result = $this->db->query($sqlStatement)->result();
        return count($result);
    }
	
	function read_member_list($perpage, $page, $data)
    {
        if ($data == null) {
            $conditions = '';
        } else {
           /* if ($data['dname'] != "") {
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
            }*/

        }
        if ($page == 0)
            $page = '';
        else
            $page = ' OFFSET ' . $page;
		 $conditions = 'where emp_is_deleted!=1';

        $sqlStatement = "SELECT * FROM members " . $conditions . " ORDER BY id desc LIMIT $perpage $page";
        return $result = $this->db->query($sqlStatement)->result();

    }
}