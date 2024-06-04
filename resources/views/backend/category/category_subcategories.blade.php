@extends('admin.admin_dashboard')
@section('admin')

<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Category with Subcategories</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Category with Subcategories</li>
                                
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										
										<th>Category Name</th>
										<th>Subcategory Name</th>
										
									</tr>
								</thead>
								<tbody>
                                   
									<tr>
										
										<td>{{$category->category_name }}</td>
										<td>
											@foreach($category->subcategories as $category->subcategory)
                                            <p>{{ $category->subcategory->subcategory_name }}</p>
											@endforeach
                                        </td>
										
										
									</tr>
									
						
								</tbody>
								<tfoot>
									<tr>
                                        <th>Category Name</th>
										<th>Subcategory Name</th>
										
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>				
			</div>

@endsection