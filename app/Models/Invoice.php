<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Invoice
 *
 * @property int $id
 * @property int $client_id
 * @property int $user_creator_id
 * @property int $user_update_id
 * @property float $sub_total
 * @property float $total_iva
 * @property float $total
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Client $client
 * @property User $user
 * @property Collection|InvoiceLine[] $invoice_lines
 *
 * @package App\Models
 */
class Invoice extends Model
{
    use HasFactory;
	protected $table = 'invoices';

	protected $casts = [
		'client_id' => 'int',
		'user_creator_id' => 'int',
		'user_update_id' => 'int',
		'sub_total' => 'float',
		'total_iva' => 'float',
		'total' => 'float'
	];

	protected $fillable = [
		'client_id',
		'user_creator_id',
		'user_update_id',
		'sub_total',
		'total_iva',
		'total'
	];

	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'user_update_id');
	}

	public function invoice_lines()
	{
		return $this->hasMany(InvoiceLine::class);
	}
}
