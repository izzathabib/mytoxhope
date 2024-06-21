<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;
use App\Models\UserModel;

class AddAdminAccount extends Seeder
{
    public function run() {
        // The data that we want to update
        $user = new User([
            'email' => 'admin@example.com',
            'password' => 'adminlapan',
            'name' => 'adminone',
            'comp_name' => 'Enam Sdn Bhd',
            'comp_reg_no' => 'A-006',
        ]);

        $model = new UserModel();
        $model -> save($user);

        // Get the inserted data
        $user = $model->findById($model->getInsertID());
        
        /* Make user able to immediately login without need to activate the account */
        $user->activate();
        /* Add $user to the associated group */
        $user->addGroup('superadmin','admin');
    }
}
