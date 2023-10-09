<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ship
 *
 * @property int $id
 * @property string $title
 * @property array $spec
 * @property string $description
 * @property int $ordering
 * @property bool $state
 *
 * @property Collection|CabinCategory[] $cabin_categories
 * @property Collection|ShipsGallery[] $ships_galleries
 *
 * @package App\Models
 */
class Ship extends Model
{
	protected $table = 'ships';
	public $timestamps = false;

	protected $casts = [
		'spec' => 'json',
		'ordering' => 'int',
		'state' => 'bool'
	];

	protected $fillable = [
		'title',
		'spec',
		'description',
		'ordering',
		'state'
	];

	public function cabin_categories()
	{
		return $this->hasMany(CabinCategory::class);
	}

	public function ships_galleries()
	{
		return $this->hasMany(ShipsGallery::class);
	}
}
