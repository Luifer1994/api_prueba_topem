<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property int $iva
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|InvoiceLine[] $invoice_lines
 *
 * @package App\Models
 */
class Product extends Model
{
    use HasFactory;
	protected $table = 'products';

	protected $casts = [
		'price' => 'float',
		'iva' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'price',
		'iva'
	];

	public function invoice_lines()
	{
		return $this->hasMany(InvoiceLine::class);
	}
}
