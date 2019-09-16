<table class="table table-hover" dir="rtl">
    <thead>
      <tr>
        <th>ردیف</th>
        <th>نام دسته</th>
        <th>نام لاتین دسته</th>
        <th>دسته والد</th>
        <th>عملیات</th>
      </tr>
    </thead>
     
    <?php $i=1; ?>
    @foreach($categories as $item)
    	<tr>
			<td>{{ $i }}</td>
			<td>{{ $item->cat_name }}</td>
			<td>{{ $item->cat_ename }}</td>		
			<td>{{ $item->getParent->cat_name }}</td>		
			<td> ویرایش | حذف </td>		
		</tr>
		<?php $i++; ?> 
	@endforeach
</table>