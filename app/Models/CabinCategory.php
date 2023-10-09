<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CabinCategory
 *
 * @property int $id
 * @property int $ship_id
 * @property string $vendor_code
 * @property string $title
 * @property string|null $type
 * @property string $description
 * @property array|null $photos
 * @property int $ordering
 * @property bool $state
 *
 * @property Ship $ship
 *
 * @package App\Models
 */
class CabinCategory extends Model
{
	protected $table = 'cabin_categories';
	public $timestamps = false;

	protected $casts = [
		'ship_id' => 'int',
		'photos' => 'json',
		'ordering' => 'int',
		'state' => 'bool'
	];

	protected $fillable = [
		'ship_id',
		'vendor_code',
		'title',
		'type',
		'description',
		'photos',
		'ordering',
		'state'
	];

	public function ship()
	{
		return $this->belongsTo(Ship::class);
	}
}
