<?php

namespace App\Services;

use App\Models\RiwayatPosyanduAnak;
use App\Repositories\Interfaces\AnakRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnakService
{
    protected $anakRepository;

    public function __construct(AnakRepositoryInterface $anakRepository)
    {
        $this->anakRepository = $anakRepository;
    }
    public function getAllAnak()
    {
        return $this->anakRepository->getAllAnak();
    }

    public function countAllAnak()
    {
        return $this->anakRepository->countAllAnak();
    }
    public function getAnakByOrangTuaId($id)
    {
        return $this->anakRepository->getAnakByOrangTuaId($id);
    }

    public function getAnakByPuskesmas($id)
    {
        return $this->anakRepository->getAnakByPuskesmas($id);
    }

    public function getAnakByPosyandu($id)
    {
        return $this->anakRepository->getAnakByPosyandu($id);
    }

    public function getAnakById($id)
    {
        return $this->anakRepository->getAnakById($id);
    }

    public function createAnak(array $data)
    {
        $anak = $this->anakRepository->createAnak($data);
        return $anak;
    }

    public function updateAnak(array $data, $id)
    {
        $anak = $this->anakRepository->updateAnak($id, $data);

        return $anak;
    }

    public function deleteAnak($id)
    {
        $user = $this->anakRepository->deleteAnak($id);

        return $user;
    }

    public function toggleAnakActive($anakId): array
    {
        $anak = $this->anakRepository->toggleAnakActive($anakId);
        return [
            'status' => 'success',
            'is_active' => $anak->isActive(),
            'message' => $anak->isActive() ? 'Anak activated successfully' : 'Anak deactivated successfully'
        ];
    }

    public function movePosyandu(array $data)
    {
        DB::beginTransaction();
        try {
            $anak = $this->anakRepository->getAnakById($data['anak_id']);

            if ($anak->posyandu_id) {
                RiwayatPosyanduAnak::create([
                    'anak_id' => $anak->id,
                    'posyandu_id' => $anak->posyandu_id,
                    'tanggal_pindah' => now()
                ]);
            }

            $this->anakRepository->updateAnak($anak->id, [
                'posyandu_id' => $data['posyandu_id']
            ]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
