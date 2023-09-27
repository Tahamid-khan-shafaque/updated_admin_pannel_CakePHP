<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Person Entity
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $department
 * @property string $bloodgroup
 * @property string $gender
 * @property string $skillset
 * @property string $image
 */
class Person extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'name' => true,
        'email' => true,
        'phone' => true,
        'department' => true,
        'bloodgroup' => true,
        'gender' => true,
        'skillset' => true,
        'image' => true,
    ];
}
