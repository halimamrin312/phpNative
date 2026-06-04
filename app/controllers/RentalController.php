<?php
class RentalController extends Controller
{

    private $rentalModel;
    private $userModel;
    private $lockerModel;
    public function __construct()
    {
        $this->rentalModel = $this->model('RentalModel');
        $this->userModel = $this->model('UserModel');
        $this->lockerModel = $this->model('LockerModel');
    }

    public function index()
    {
        $data['judul'] = "Rental";
        $data['rentals'] = $this->rentalModel->getAllRentals();
        return $this->view('rental/index', $data);
    }

    public function create()
    {
        $data['judul'] = "Rental";
        $data['nextId'] = $this->rentalModel->getLastId();
        $data['nextId'] = intval($data['nextId']) + 1;
        $data['users'] = $this->userModel->getAllUsers();
        $data['lockers'] = $this->lockerModel->getNotOwnedLockers();
        // echo $data['userIds'];
        return $this->view('rental/create', $data);
    }

    public function createStore()
    {
        $id = htmlspecialchars($_POST['id']);
        $userId = htmlspecialchars($_POST['userId']);
        $lockerId = htmlspecialchars($_POST['lockerId']);
        // echo $id . $userId . $lockerId;

        $valid = $this->rentalModel->createRental($id, $userId, $lockerId);
        if ($valid) {
            return $this->index();
        } else {
            echo "Locker gagal dibuat";
        }
    }
    public function delete($id)
    {
        $valid = $this->rentalModel->delete($id);

        if ($valid) {
            return $this->index();
        } else {
            echo "Rental gagal dihapus";
        }
    }

    public function sneakDelete()
    {
        $id = htmlspecialchars($_POST['id']);
        $this->delete($id);
    }


    public function edit($id, $userId, $lockerId)
    {
        $data['judul'] = 'myLocker';
        $data['id'] = $id;
        $data['userId'] = $userId;
        $data['lockerId'] = $lockerId;

        $data['users'] = $this->userModel->getAllUsers();
        $data['lockers'] = $this->lockerModel->getNotOwnedLockers();

        return $this->view('rental/edit', $data);
    }

    public function editStore()
    {
        $id = htmlspecialchars($_POST['id']);
        $userId = htmlspecialchars($_POST['userId']);
        $lockerId = htmlspecialchars($_POST['lockerId']);


        $validUpdate = $this->rentalModel->update($id, $userId, $lockerId);

        if ($validUpdate) {
            $this->index();
        } else {
            echo " Tapi Gagal Update, Cek Kembali data anda" . $validUpdate;
        }
    }
}