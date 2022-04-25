<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 *
 * @property int $id
 * @property string $name
 * @property string $nit
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Company extends Model
{
    use HasFactory;
	protected $table = 'companies';

	protected $fillable = [
		'name',
		'nit'
	];

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
