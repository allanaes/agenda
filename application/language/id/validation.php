<?php 

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used
	| by the validator class. Some of the rules contain multiple versions,
	| such as the size (max, min, between) rules. These versions are used
	| for different input types such as strings and files.
	|
	| These language lines may be easily changed to provide custom error
	| messages in your application. Error messages for custom validation
	| rules may also be added to this file.
	|
	*/

	"accepted"       => ":attribute harus diterima.",
	"active_url"     => ":attribute bukan URL yang valid.",
	"after"          => ":attribute harus tanggal setelah :date.",
	"alpha"          => ":attribute hanya boleh menggunakan huruf.",
	"alpha_dash"     => ":attribute hanya boleh menggunakan huruf, angka, dan tanda strip.",
	"alpha_num"      => ":attribute hanya boleh menggunakan huruf dan angka.",
	"before"         => ":attribute harus tanggal sebelum :date.",
	"between"        => array(
		"numeric" => ":attribute harus di antara :min - :max.",
		"file"    => ":attribute harus di antara :min - :max kilobyte.",
		"string"  => ":attribute harus di antara :min - :max karakter.",
	),
	"confirmed"      => "Konfirmasi :attribute tidak cocok.",
	"date_format"   => ":attribute harus menggunakan format yang valid.",
	"different"      => ":attribute dan :other harus berbeda.",
	"email"          => "Format :attribute tidak valid.",
	"exists"         => ":attribute terpilih tidak valid.",
	"image"          => ":attribute harus sebuah gambar.",
	"in"             => ":attribute terpilih tidak valid.",
	"integer"        => ":attribute harus bilangan bulat.",
	"ip"             => ":attribute harus berupa alamat IP yang valid.",
	"match"          => "Format :attribute tidak valid.",
	"max"            => array(
		"numeric" => ":attribute harus lebih kecil dari :max.",
		"file"    => ":attribute harus lebih kecil dari :max kilobyte.",
		"string"  => ":attribute harus lebih kecil dari :max karakter.",
	),
	"mimes"          => ":attribute harus file dengan tipe: :values.",
	"min"            => array(
		"numeric" => ":attribute harus sedikitnya :min.",
		"file"    => ":attribute harus sedikitnya :min kilobyte.",
		"string"  => ":attribute harus sedikitnya :min karakter.",
	),
	"not_in"         => ":attribute terpilih tidak valid.",
	"numeric"        => ":attribute harus berupa angka.",
	"required"       => ":attribute harus diisi.",
	"same"           => ":attribute dan :other harus cocok.",
	"size"           => array(
		"numeric" => ":attribute harus :size.",
		"file"    => ":attribute harus :size kilobyte.",
		"string"  => ":attribute harus :size karakter.",
	),
	"unique"         => ":attribute sudah digunakan.",
	"url"            => "Format :attribute tidak valid.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute_rule" to name the lines. This helps keep your
	| custom validation clean and tidy.
	|
	| So, say you want to use a custom validation message when validating that
	| the "email" attribute is unique. Just add "email_unique" to this array
	| with your custom message. The Validator will handle the rest!
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as "E-Mail Address" instead
	| of "email". Your users will thank you.
	|
	| The Validator class will automatically search this array of lines it
	| is attempting to replace :attribute place-holder in messages.
	| It's pretty slick. We think you'll like it.
	|
	*/

	'attributes' => array(),

);