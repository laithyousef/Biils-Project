@extends('layouts.master')

@section('title', 'تفاصيل الفاتورة')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتورة</span>
						</div>
					</div>
                </div>

				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
                    <div class="col-xl-12">
                    <div class="card mg-b-20" id="tabs-style2">
                        <div class="card-body">
                            <div class="text-wrap">
                                <div class="example">
                    <div class="panel panel-primary tabs-style-2">
                        <div class=" tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs main-nav-line">
                                    <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات الفاتورة</a></li>
                                    <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الفاتورة</a></li>
                                    <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab4">
                                    <div class="table-responsive mt-15">


                                        <table class="table table-striped" style="text-align:center">
                                            <tbody>
                                         
                                                <tr>
                                                    <th scope="row"><strong>رقم الفاتورة :</strong></th>
                                                    <td>{{ $invoices->invoice_number }}</td>
                                                    <th scope="row"><strong>تاريخ الاصدار :</strong></th>
                                                    <td>{{ $invoices->invoice_Date }}</td>
                                                    <th scope="row"><strong>تاريخ الاستحقاق :</strong></th>
                                                    <td>{{ $invoices->Due_date }}</td>
                                                    <th scope="row"><strong>القسم :</strong></th>
                                                    <td>{{ $invoices->Section->section_name }}</td>
                                                </tr>

                                                <tr>
                                                    <th scope="row"><strong>المنتج :</strong></th>
                                                    <td>{{ $invoices->product }}</td>
                                                    <th scope="row"><strong>مبلغ التحصيل :</strong></th>
                                                    <td>{{ $invoices->Amount_collection }}</td>
                                                    <th scope="row"><strong>مبلغ العمولة :</strong></th>
                                                    <td>{{ $invoices->Amount_Commission }}</td>
                                                    <th scope="row"><strong>الخصم :</strong></th>
                                                    <td>{{ $invoices->Discount }}</td>
                                                </tr>


                                                <tr>
                                                    <th scope="row"><strong>نسبة الضريبة :</strong></th>
                                                    <td>{{ $invoices->Rate_VAT }}</td>
                                                    <th scope="row"><strong>قيمة الضريبة :</strong></th>
                                                    <td>{{ $invoices->Value_VAT }}</td>
                                                    <th scope="row"><strong>الاجمالي مع الضريبة :</strong></th>
                                                    <td>{{ $invoices->Total }}</td>
                                                    <th scope="row"><strong>الحالة الحالية :</strong></th>

                                                    @if ($invoices->Value_Status == 1)
                                                        <td><span
                                                                class="badge badge-pill badge-success">{{ $invoices->Status }}</span>
                                                        </td>
                                                    @elseif($invoices->Value_Status == 2)
                                                        <td><span
                                                                class="badge badge-pill badge-danger">{{ $invoices->Status }}</span>
                                                        </td>
                                                    @elseif ($invoices->Value_Status == 3)
                                                        <td><span
                                                                class="badge badge-pill badge-warning">{{ $invoices->Status }}</span>
                                                        </td>
                                                    @endif
                                                </tr>

                                                <tr>
                                                    <th scope="row"><strong>ملاحظات :</strong></th>
                                                    <td>{{ $invoices->note }}</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div class="tab-pane" id="tab5">
                                    <div class="table-responsive mt-15">
                                        <table class="table center-aligned-table mb-0 table-hover"
                                            style="text-align:center">
                                            <thead>
                                                <tr class="text-dark">
                                                    <th>#</th>
                                                    <th>رقم الفاتورة</th>
                                                    <th>نوع المنتج</th>
                                                    <th>القسم</th>
                                                    <th>حالة الدفع</th>
                                                    <th>تاريخ الدفع </th>
                                                    <th>ملاحظات</th>
                                                    <th>تاريخ الاضافة </th>
                                                    <th>المستخدم</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;?>
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $invoice_details->invoice_number }}</td>
                                                        <td>{{ $invoice_details->product }}</td>
                                                        <td>{{ $invoices->Section->section_name }}</td>
                                                        <td>   @if ($invoices->Value_Status == 1)
                                                            <span class="text-success">{{ $invoices->Status }}</span>
                                                            @elseif($invoices->Value_Status == 2)
                                                                <span class="text-danger">{{ $invoices->Status }}</span>
                                                            @elseif ($invoices->Value_Status == 3)
                                                                <span class="text-warning">{{ $invoices->Status }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $invoice_details->Payment_Date }}</td>
                                                        <td>{{ $invoice_details->note }}</td>
                                                        <td>{{ $invoice_details->created_at }}</td>
                                                        <td>{{ $invoice_details->user }}</td>
                                                    </tr>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                                <div class="tab-pane" id="tab6">
                                    <div class="table-responsive mt-15">
                                        <div class="card-body">
                                            @can('اضافة مرفق')                 
                                            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                            <h5 class="card-title">اضافة مرفقات</h5>
                                            <form method="post" action="{{ route('invoices_Attachments.store') }}"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile"
                                                        name="file_name" required>
                                                    <input type="hidden" id="customFile" name="invoice_number"
                                                        value="{{ $invoices->invoice_number }}">
                                                    <input type="hidden" id="invoice_id" name="invoice_id"
                                                        value="{{ $invoices->id }}">
                                                   <label class="custom-file-label" for="customFile">حدد المرفق </label>
                                                </div><br><br>
                                                <button type="submit" class="modal-effect btn btn-outline-dark "
                                                    name="uploadedFile">تاكيد</button>
                                            </form>
                                            @endcan
                                        </div>

                                    <br>


                                        <table class="table center-aligned-table mb-0 table-hover"
                                            style="text-align:center">
                                            <thead>
                                                <tr class="text-dark">
                                                    <th scope="col">م</th>
                                                    <th scope="col">اسم الملف</th>
                                                    <th scope="col">قام بالاضافة</th>
                                                    <th scope="col">تاريخ الاضافة</th>
                                                    <th scope="col">العمليات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0; ?>
                                                @foreach ( $invoice_attachments as $attachment)
                                                    <?php $i++; ?>
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $attachment->file_name }}</td>
                                                        <td>{{ $attachment->Created_by }}</td>
                                                        <td>{{ $attachment->created_at }}</td>
                                                        <td colspan="2">

                                                            @can('عرض المرفق')                 
                                                            <a class="btn btn-outline-success btn-sm"
                                                                href="{{ url('View_file') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                                role="button"><i class="fas fa-eye"></i>&nbsp; عرض  </a>
                                                            @endcan

                                                            @can('تحميل المرفق')                 
                                                            <a class="btn btn-outline-info btn-sm"
                                                                href="{{ url('download') }}/{{ $invoices->invoice_number }}/{{ $attachment->file_name }}"
                                                                role="button"><i                                                                
                                                                    class="fas fa-download"></i>&nbsp; تحميل   </a>
                                                            @endcan

                                                            @can('حذف المرفق')                 
                                                                <button class="btn btn-outline-danger btn-sm"
                                                                    data-toggle="modal"
                                                                    data-file_name="{{ $attachment->file_name }}"
                                                                    data-invoice_number="{{ $attachment->invoice_number }}"
                                                                    data-id_file="{{ $attachment->id }}"
                                                                    data-target="#delete_file">حذف</button>
                                                            @endcan

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
           	</div>
				<!-- row closed -->

                 <!-- delete -->
            <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="invoices_Attachments/destroy" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p class="text-center">
                            <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                            </p>

                            <input type="hidden" name="id_file" id="id_file" value="">
                            <input type="hidden" name="file_name" id="file_name" value="">
                            <input type="hidden" name="invoice_number" id="invoice_number" value="">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
            </div>

			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')

<script>
    $('#delete_file').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id_file = button.data('id_file')
        var file_name = button.data('file_name')
        var invoice_number = button.data('invoice_number')
        var modal = $(this)
        modal.find('.modal-body #id_file').val(id_file);
        modal.find('.modal-body #file_name').val(file_name);
        modal.find('.modal-body #invoice_number').val(invoice_number);
    })
</script>

@endsection
