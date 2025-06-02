<?php

namespace App\Http\Livewire\Tracking;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\Tracking\Tracking;
use Illuminate\Support\Facades\Auth;

class Trackin extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $Tracking = [];
    public $TrackinSearch, $Trackin, $TrackinId;
    public $user_id, $page_name, $operation_type, $operation_time, $details;
    public $search = ['user_id' => '', 'page_name' => '', 'operation_type' => '', 'operation_time' => '', 'details' => ''];

    public function updatedSearch($value, $key)
    {
        if (in_array($key, ['user_id', 'page_name', 'operation_type', 'operation_time', 'details'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $user_idSearch = '%' . $this->search['user_id'] . '%';
        $page_nameSearch = '%' . $this->search['page_name'] . '%';
        $operation_typeSearch = '%' . $this->search['operation_type'] . '%';
        $operation_timeSearch = '%' . $this->search['operation_time'] . '%';
        $detailsSearch = '%' . $this->search['details'] . '%';

        $Tracking = Tracking::query()
            ->when($this->search['user_id'], function ($query) use ($user_idSearch) {
                $query->whereHas('Getuser', function ($q) use ($user_idSearch) {
                    $q->where('name', 'LIKE', $user_idSearch);
                });
            })
            ->when($this->search['page_name'], function ($query) use ($page_nameSearch) {
                $query->where('page_name', 'LIKE', $page_nameSearch);
            })
            ->when($this->search['operation_type'], function ($query) use ($operation_typeSearch) {
                $query->where('operation_type', 'LIKE', $operation_typeSearch);
            })
            ->when($this->search['operation_time'], function ($query) use ($operation_timeSearch) {
                $query->where('operation_time', 'LIKE', $operation_timeSearch);
            })
            ->when($this->search['details'], function ($query) use ($detailsSearch) {
                $query->where('details', 'LIKE', $detailsSearch);
            })
            ->orderBy('operation_time', 'DESC')
            ->paginate(10);

        $links = $Tracking;
        $this->Tracking = collect($Tracking->items());
        return View('livewire.tracking.trackin', [
            'Tracking' => $Tracking,
            'links' => $links
        ]);
    }


    public function AddTrackinModalShow()
    {
        $this->reset();
        $this->resetValidation();
        $this->dispatchBrowserEvent('TrackinModalShow');
    }


    public function store()
    {
        $this->resetValidation();
        $this->validate([
            'user_id' => 'required',
            'page_name' => 'required',
            'operation_type' => 'required',
            'operation_time' => 'required',
            'details' => 'required',

        ], [
            'user_id.required' => 'حقل  مطلوب',
            'page_name.required' => 'حقل اسم النافذة مطلوب',
            'operation_type.required' => 'حقل نوع العملية مطلوب',
            'operation_time.required' => 'حقل وقت العملية مطلوب',
            'details.required' => 'حقل تفاصيل العملية مطلوب',
        ]);
        Tracking::create([
            'user_id' => Auth::id(),
            'page_name' => $this->page_name,
            'operation_type' => $this->operation_type,
            'operation_time' => $this->operation_time,
            'details' => $this->details,
        ]);
    }

    public function GetTrackin($TrackinId)
    {
        $this->resetValidation();

        $this->Trackin  = Tracking::find($TrackinId);
        $this->TrackinId = $this->Trackin->id;
        $this->user_id = $this->Trackin->user_id;
        $this->page_name = $this->Trackin->page_name;
        $this->operation_type = $this->Trackin->operation_type;
        $this->operation_time = $this->Trackin->operation_time;
        $this->details = $this->Trackin->details;
    }

    public function update()
    {
        $this->resetValidation();
        $this->validate([
            'user_id' => 'required:tracking',
            'page_name' => 'required:tracking',
            'operation_type' => 'required:tracking',
            'operation_time' => 'required:tracking',
            'details' => 'required:tracking',

        ], [
            'user_id.required' => 'حقل  مطلوب',
            'page_name.required' => 'حقل اسم النافذة مطلوب',
            'operation_type.required' => 'حقل نوع العملية مطلوب',
            'operation_time.required' => 'حقل وقت العملية مطلوب',
            'details.required' => 'حقل تفاصيل العملية مطلوب',
        ]);

        $Tracking = Tracking::find($this->TrackinId);
        $Tracking->update([
            'user_id' => $this->user_id,
            'page_name' => $this->page_name,
            'operation_type' => $this->operation_type,
            'operation_time' => $this->operation_time,
            'details' => $this->details,

        ]);
        $this->reset();
        $this->dispatchBrowserEvent('success', [
            'message' => 'تم التعديل بنجاح',
            'title' => 'تعديل'
        ]);
    }

    public function destroy()
    {
        $Tracking = Tracking::find($this->TrackinId);

        if ($Tracking) {

            $Tracking->delete();
            $this->reset();
            $this->dispatchBrowserEvent('success', [
                'message' => 'تم حذف البيانات بنجاح',
                'title' => 'الحذف'
            ]);
        }
    }
}
