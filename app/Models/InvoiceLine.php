<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class InvoiceLine
 *
 * @property int $id
 * @property int $product_id
 * @property int $invoice_id
 * @property int $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Invoice $invoice
 * @property Product $product
 *
 * @package App\Models
 */
class InvoiceLine extends Model
{
    use HasFactory;
	protected $table = 'invoice_lines';

	protected $casts = [
		'product_id' => 'int',
		'invoice_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'product_id',
		'invoice_id',
		'quantity'
	];

	public function invoice()
	{
		return $this->belongsTo(Invoice::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
