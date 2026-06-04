<?php
class LockerController extends Controller
{
    private $lockerModel;

    public function __construct()
    {
        $this->lockerModel = $this->model('LockerModel');
    }
    public function index()
    {
        $data['judul'] = 'myLocker';
        $data['lockers'] = $this->lockerModel->getAllLockers();
        $data['controller'] = basename(__FILE__, '.php');
        return $this->view('locker/index', $data);
        // $pass = "anjay123";
        // $passHash = password_hash($pass, PASSWORD_DEFAULT);
        // $test = "anjay123";
        // $passUnHash = password_verify($test, $passHash);
        // echo $passHash . "</br>";
        // echo $passUnHash;
    }
    public function create()
    {
        $data['judul'] = 'myLocker';
        $data['nextId'] = $this->lockerModel->getLastId();
        $data['nextId'] = str_replace('LK-', '', $data['nextId']);
        $data['nextId'] = intval($data['nextId']) + 1;
        // echo $data['nextId'];
        return $this->view('locker/create', $data);
    }

    public function createStore()
    {
        $id = htmlspecialchars($_POST['id']);
        $secreetKey = htmlspecialchars($_POST['secreetKey']);

        $valid = $this->lockerModel->createLocker($id, $secreetKey);

        if ($valid) {
            return $this->index();
        } else {
            echo "Locker gagal dibuat";
        }
    }

    public function delete($id)
    {
        $valid = $this->lockerModel->deleteLocker($id);

        if ($valid) {
            return $this->index();
        } else {
            echo "Locker gagal dihapus";
        }
    }

    public function sneakDelete()
    {
        $id = htmlspecialchars($_POST['id']);
        $this->delete($id);
    }

    public function edit($id)
    {
        $data['judul'] = 'myLocker';
        $valid = $this->lockerModel->getLocker($id);
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

        $validPassword = $this->lockerModel->openLocker($data['id'], $data['oldSecreetKey']);

        if ($validPassword) {
            echo "Password Matching";

            $data['status'] = htmlspecialchars($_POST['status']);
            $data['secreetKey'] = htmlspecialchars($_POST['secreetKey']);

            // echo json_encode($data);
            $validUpdate = $this->lockerModel->updateLocker($data);

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
        $valid = $this->lockerModel->openLocker($id, $secretKey);

        if ($valid) {
            echo "Locker has been opened";
            echo "Locker ID: " . $id . " secretKey: " . $secretKey;
        } else {
            echo "Locker is not valid";
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