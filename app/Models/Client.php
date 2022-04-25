<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 *
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $document_number
 * @property int $document_type_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property DocumentType $document_type
 * @property Collection|Invoice[] $invoices
 *
 * @package App\Models
 */
class Client extends Model
{
    use HasFactory;
	protected $table = 'clients';

	protected $casts = [
		'document_type_id' => 'int'
	];

	protected $fillable = [
		'name',
		'last_name',
		'document_number',
		'document_type_id'
	];

	public function document_type()
	{
		return $this->belongsTo(DocumentType::class);
	}

	public function invoices()
	{
		return $this->hasMany(Invoice::class);
	}
}
