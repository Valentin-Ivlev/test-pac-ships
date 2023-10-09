<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShipsGallery
 *
 * @property int $id
 * @property int $ship_id
 * @property string $title
 * @property string $url
 * @property int $ordering
 *
 * @property Ship $ship
 *
 * @package App\Models
 */
class ShipsGallery extends Model
{
	protected $table = 'ships_gallery';
	public $timestamps = false;

	protected $casts = [
		'ship_id' => 'int',
		'ordering' => 'int'
	];

	protected $fillable = [
		'ship_id',
		'title',
		'url',
		'ordering'
	];

	public function ship()
	{
		return $this->belongsTo(Ship::class);
	}
}
