<?php

namespace App\Models\Sys;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\SysModel;
use Illuminate\Database\Eloquent\Builder;

class MsReference extends SysModel
{
    use HasFactory;

    public $fillable = [
        'name', 'cat_id', 'cat_name',
    ];

    const VALIDATION_RULES = [];

    const JENIS_PETANI_MITRA_CID = 1;
    const TINDAK_LANJUT_SST_CID = 2;

    const TTBS_GOLONGAN_BENIH_CID = 3;
    const TTBS_GOLONGAN_BENIH_OP_ID = "OP";
    const TTBS_GOLONGAN_BENIH_HIBRIDA_ID = "HIBRIDA";

    const TTBS_WILAYAH_BENIH_CID = 4;
    const TTBS_WILAYAH_BENIH_IT_ID = "IT";
    const TTBS_WILAYAH_BENIH_IB_ID = "IB";
    const TTBS_WILAYAH_BENIH_PDG_ID = "PDG";

    const TTBS_JENIS_LOT_CID = 5;
    const TTBS_JENIS_LOT_GOOD_KP_ID = 14;

    const TTBS_TREATMENT_CID = 6;

    const LAB_STATUS_REKOM_CID = 7;
    const LAB_STATUS_REKOM_GOT_ID = "GOT";
    const LAB_STATUS_REKOM_RTG_ID = "Release Tanpa GOT";

    const ACUAN_PB_MACAM_UJI = 8;

    const SEED_ADMIN_PROCESSING_STAFF_ADMIN_ID = 32;
    const RPB_KETERANGAN_RPB_CID = 10;
    const PROSES_JENIS_LOT_CID = 11;
    const PROSES_JENIS_SST_CID = 20;
    const PROSES_JENIS_3N_CID = 20;
    const PROSES_TREATMENT_CID = 12;
    const PROSES_KETERANGAN_CID = 13;

    const TANDA_TERIMA_MACAM_CID = 14;
    const TANDA_TERIMA_MACAM_BULKY_ID = 50;
    const TANDA_TERIMA_MACAM_MIXING_ID = 51;
    const TANDA_TERIMA_MACAM_TL_ID = 52;

    const BRANG_JADI_JENIS_CID = 15;
    const PRODUK_KODE_GOL_CID = 16;

    const KD_PRODUKSI_KELAS_BENIH_CID = 17;
    const KD_PRODUKSI_GOLONGAN_BENIH_CID = 18;
    const KD_PRODUKSI_GROUP_BENIH_CID = 19;

    public function scopeByCat($query, $catId): Builder
    {
        return $query->where([
            ['cat_id', $catId],
        ]);
    }

    public function scopeById($query, $id): Builder
    {
        return $query->where([
            ['id', $id],
        ]);
    }
}
