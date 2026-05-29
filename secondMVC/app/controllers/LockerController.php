<?php
class LockerController extends Controller
{
    public function index()
    {
        $data['judul'] = 'myLocker';
        $data['lockers'] = $this->model('LockerModel')->getAllLockers();
        $data['controller'] = basename(__FILE__, '.php');
        return $this->view('locker/index', $data);
    }
    public function create()
    {
        $data['judul'] = 'myLocker';
        $data['nextId'] = $this->model('LockerModel')->getLastId();
        $data['nextId'] = str_replace('LK-', '', $data['nextId']);
        $data['nextId'] = intval($data['nextId']) + 1;
        return $this->view('locker/create', $data);
        // echo $data['nextId'];
    }

    public function createStore()
    {
        $id = htmlspecialchars($_POST['id']);
        $secreetKey = htmlspecialchars($_POST['secreetKey']);
        $valid = $this->model('LockerModel')->createLocker($id, $secreetKey);
        if ($valid) {
            return $this->index();
        } else {
            echo "Locker gagal dibuat";
        }
    }

    public function delete($id)
    {
        $valid = $this->model('LockerModel')->deleteLocker($id);

        if ($valid) {
            return $this->index();
        } else {
            echo "Locker gagal dihapus";
        }
    }
    public function edit($id)
    {
        $data['judul'] = 'myLocker';
        $valid = $this->model('LockerModel')->getLocker($id);
        if ($valid) {
            $data['locker'] = $valid;
            return $this->view('locker/edit', $data);
            // echo json_encode($valid);
        } else {
            echo "Locker gagal dimuat";
        }
    }

    public function editStore()
    {
        $data['id'] = htmlspecialchars($_POST['id']);
        $data['oldSecreetKey'] = htmlspecialchars($_POST['oldSecreetKey']);
        $validPassword = $this->model('LockerModel')->openLocker($data['id'], $data['oldSecreetKey']);

        if ($validPassword) {
            echo "Password Matching";

            $data['status'] = htmlspecialchars($_POST['status']);
            $data['secreetKey'] = htmlspecialchars($_POST['secreetKey']);
            // echo json_encode($data);
            $validUpdate = $this->model('LockerModel')->updateLocker($data);

            if ($validUpdate) {
                $this->index();
            } else {
                echo " Tapi Gagal Update, Cek Kembali data anda" . $validUpdate;
            }

        } else {
            echo "Password tidak Matching";
        }
    }

    public function openLocker($id, $secretKey)
    {
        $valid = $this->model('LockerModel')->openLocker($id, $secretKey);

        if ($valid) {
            echo "Locker telah terbuka";
            echo "Locker ID: " . $id . " secretKey: " . $secretKey;
        } else {
            echo "Locker tidak valid";
        }
    }

    public function sneakInLocker()
    {
        $id = htmlspecialchars($_POST['id']);
        $secreetKey = htmlspecialchars($_POST['secreetKey']);
        $this->openLocker($id, $secreetKey);
    }
    public function getLocker($param1, $param2)
    {
        $data['id'] = $param1;
        $data['status'] = $param2;
        return $this->view('locker/openLocker', $data);
    }
}