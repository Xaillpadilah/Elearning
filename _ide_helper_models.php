<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUserId($value)
 */
	class Admin extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $from
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chat whereUpdatedAt($value)
 */
	class Chat extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $nama
 * @property string $nik
 * @property string $jenis_kelamin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Kelas> $kelas
 * @property-read int|null $kelas_count
 * @property-read \App\Models\Kelas|null $kelasWali
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GuruMapelKelas> $mapelKelas
 * @property-read int|null $mapel_kelas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Mapel> $mapels
 * @property-read int|null $mapels_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Guru newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guru newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Guru query()
 * @method static \Illuminate\Database\Eloquent\Builder|Guru whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guru whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guru whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guru whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guru whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guru whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Guru whereUserId($value)
 */
	class Guru extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $guru_id
 * @property int $mapel_id
 * @property int $kelas_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Guru $guru
 * @property-read \App\Models\Kelas $kelas
 * @property-read \App\Models\Mapel $mapel
 * @method static \Illuminate\Database\Eloquent\Builder|GuruMapelKelas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GuruMapelKelas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GuruMapelKelas query()
 * @method static \Illuminate\Database\Eloquent\Builder|GuruMapelKelas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuruMapelKelas whereGuruId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuruMapelKelas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuruMapelKelas whereKelasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuruMapelKelas whereMapelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GuruMapelKelas whereUpdatedAt($value)
 */
	class GuruMapelKelas extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_kelas
 * @property string $wali_kelas
 * @property int $jumlah_siswa
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Siswa> $siswa
 * @property-read int|null $siswa_count
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas query()
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas whereJumlahSiswa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas whereNamaKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Kelas whereWaliKelas($value)
 */
	class Kelas extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $kode_mapel
 * @property string $nama_mapel
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Guru> $gurus
 * @property-read int|null $gurus_count
 * @method static \Illuminate\Database\Eloquent\Builder|Mapel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mapel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mapel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mapel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mapel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mapel whereKodeMapel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mapel whereNamaMapel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mapel whereUpdatedAt($value)
 */
	class Mapel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $judul
 * @property \App\Models\Mapel|null $mapel
 * @property \App\Models\Kelas|null $kelas
 * @property string $file
 * @property string|null $uploaded_at
 * @property int|null $mapel_id
 * @property int|null $kelas_id
 * @property int|null $guru_id
 * @property int|null $uploaded_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Guru|null $guru
 * @property-read \App\Models\User|null $uploader
 * @method static \Illuminate\Database\Eloquent\Builder|Materi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Materi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Materi query()
 * @method static \Illuminate\Database\Eloquent\Builder|Materi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materi whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materi whereGuruId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materi whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materi whereKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materi whereKelasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materi whereMapel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materi whereMapelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materi whereUploadedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Materi whereUploadedBy($value)
 */
	class Materi extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $siswa_id
 * @property string $nama
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Orangtua newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orangtua newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Orangtua query()
 * @method static \Illuminate\Database\Eloquent\Builder|Orangtua whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orangtua whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orangtua whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orangtua whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orangtua whereSiswaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orangtua whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Orangtua whereUserId($value)
 */
	class Orangtua extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder|Pengumuman newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengumuman newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pengumuman query()
 */
	class Pengumuman extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $nama
 * @property string $nisn
 * @property string $email
 * @property int $kelas_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Kelas $kelas
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa query()
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa whereKelasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa whereNisn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Siswa whereUserId($value)
 */
	class Siswa extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin|null $admin
 * @property-read \App\Models\Guru|null $guru
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Orangtua|null $orangtua
 * @property-read \App\Models\Siswa|null $siswa
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

