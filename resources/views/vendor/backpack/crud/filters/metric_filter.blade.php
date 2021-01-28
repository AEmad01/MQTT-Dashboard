{{-- Text Backpack CRUD filter --}}

<li filter-name="{{ $filter->name }}"
	filter-type="{{ $filter->type }}"
	class="nav-item dropdown {{ Request::get($filter->name) ? 'active' : '' }}">
	<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $filter->label }} <span class="caret"></span></a>
	<div class="dropdown-menu p-0">
		<div class="form-group backpack-filter mb-0">
			<div class="input-group">
		        <input class="form-control pull-right"
		        		id="text-filter-{{ str_slug($filter->name) }}"
		        		type="text"
						@if ($filter->currentValue)
							value="{{ $filter->currentValue }}"
						@endif
		        		>
		        <div class="input-group-append text-filter-{{ str_slug($filter->name) }}-clear-button">
		          <a class="input-group-text" href=""><i class="fa fa-times"></i></a>
		        </div>
		    </div>
		</div>
	</div>
</li>

  {{-- ########################################### --}}
  {{-- Extra CSS and JS for this particular filter --}}

  {{-- FILTERS EXTRA JS --}}
  {{-- push things in the after_scripts section --}}

  @push('crud_list_scripts')
    <!-- include select2 js-->
    <script>
        function getIndex(name) {
    var column = name;
    var indexFound = 0;
    $('#crudTable').find('th:not([data-visible-in-export])').toArray().some(function(item, index) {

        indexFound++;
        if (item.innerHTML == column) {
            console.log(index);
            return true;
        }
    });
    return indexFound - 1;

}
var flagWipe = false;



jQuery(document).ready(function($) {
    $('li[filter-name="client"]').hide();
    $('#text-filter-{{ str_slug($filter->name) }}').on('change', function(e) {
        var parameter = '{{ $filter->name }}';
        var ColIndex = getIndex(parameter); //column index

					$('li[filter-name={{ $filter->name }}]').removeClass('active').addClass('active');

                    $('#remove_filters_button').on('click', function(e) {				$('li[filter-name={{ $filter->name }}]').removeClass('active');
                    $('#text-filter-{{ str_slug($filter->name) }}').val('');
                    $('#remove_filters_button').addClass('invisible');


});


        $('.text-filter-{{ str_slug($filter->name) }}-clear-button').on('click', function(e) {
            // behaviour for ajax table
            var new_url = 'http://127.0.0.1/admin/client/search';
            var ajax_table = $("#crudTable").DataTable();
				$('li[filter-name={{ $filter->name }}]').removeClass('active');
				$('#text-filter-{{ str_slug($filter->name) }}').val('');
            // replace the datatables ajax url with new_url and reload it
            ajax_table.ajax.url(new_url).load();

            // clear all filters
            $(".navbar-filters li[filter-name]").trigger('filter:clear');

            // remove filters from URL
            crud.updateUrl(new_url);

        })

        var value = $(this).val();

        // behaviour for ajax table
        var ajax_table = $('#crudTable').DataTable();
        var flagFound = false;
        var toDraw = [];

        if (value.includes('>')) {
            $('#crudTable').DataTable().rows().every(function() {
                var that = this;
                that.data().forEach(
                    function(item, index, that) {
                        var thatOld = that;
                        if (parseInt(item.replace(/<\/?span[^>]*>/g, "").replace(/\n/g,'')) > parseInt(value.replace(/>/g,'')) && index == getIndex(parameter)) {
                            if (item.replace(/<\/?span[^>]*>/g, "").replace(/\n/g,'')!="none")
                            {
                                console.log(item.replace(/<\/?span[^>]*>/g, "") + "is > than " + value.replace(/>/g,''));
                                toDraw.push(thatOld[0].replace(/<\/?span[^>]*>/g, ""));
                            flagFound = true;
                            }



                        }
                    });
            }

        );        }

        else if (value.includes('<')) {
            $('#crudTable').DataTable().rows().every(function() {
                var that = this;
                that.data().forEach(
                    function(item, index, that) {
                        var thatOld = that;
                        if (parseInt(item.replace(/<\/?span[^>]*>/g, "").replace(/\n/g,'')) < parseInt(value.replace(/</g,'')) && index == getIndex(parameter)) {
                            if (item.replace(/<\/?span[^>]*>/g, "").replace(/\n/g,'')!="none")
                            {
                                console.log(item.replace(/<\/?span[^>]*>/g, "") + "is < than " + value.replace(/</g,''));
                            toDraw.push(thatOld[0].replace(/<\/?span[^>]*>/g, ""));
                            flagFound = true;
                            }
                        }
                    });
            }

        );        }//5-10
        else if (value.includes('-')) {
            console.log(value);
            $('#crudTable').DataTable().rows().every(function() {
                var that = this;
                that.data().forEach(
                    function(item, index, that) {
                        var thatOld = that;
                        if ((parseInt(item.replace(/<\/?span[^>]*>/g, "").replace(/\n/g,'')) > parseInt(value.split("-")[0]) && parseInt(item.replace(/<\/?span[^>]*>/g, "").replace(/\n/g,'')) < parseInt(value.split("-")[1] )) && index == getIndex(parameter)) {
                            if (item.replace(/<\/?span[^>]*>/g, "").replace(/\n/g,'')!="none")
                            {
                            toDraw.push(thatOld[0].replace(/<\/?span[^>]*>/g, ""));
                            flagFound = true;
                            }
                        }
                    });
            }

        );        }

        else{$('#crudTable').DataTable().rows().every(function() {
                var that = this;
                that.data().forEach(
                    function(item, index, that) {
                        var thatOld = that;
                        console.log(parseInt(value),10);
                        console.log(item.replace(/<\/?span[^>]*>/g, "").replace(/\n/g,''));
                        if(typeof(value)!=String)
                        if (parseInt(item.replace(/<\/?span[^>]*>/g, "").replace(/\n/g,''))==parseInt(value) && index == getIndex(parameter)) {

                            toDraw.push(thatOld[0].replace(/<\/?span[^>]*>/g, ""));
                            flagFound = true;

                        }
                        else{
                            if (item.replace(/<\/?span[^>]*>/g, "").replace(/\n/g,'')==value && index == getIndex(parameter)) {

toDraw.push(thatOld[0].replace(/<\/?span[^>]*>/g, ""));
flagFound = true;

}
                        }
                    });
            }

        );

        }

if (!flagFound)
{
    toDraw.push('none');
}
        ajax_table = $('#crudTable').DataTable();
        var current_url = ajax_table.ajax.url();
        var new_url = addOrUpdateUriParameter(current_url, 'client', toDraw.toString());

        // replace the datatables ajax url with new_url and reload it
        new_url = normalizeAmpersand(new_url.toString());
        ajax_table.ajax.url(new_url).load();

        // add filter to URL
        // add filter to URL
        crud.updateUrl(new_url);

        // mark this filter as active in the navbar-filters
        if (URI(new_url).hasQuery('{{ $filter->name }}', true)) {
            $('li[filter-name={{ $filter->name }}]').removeClass('active').addClass('active');
        } else {
            $('li[filter-name={{ $filter->name }}]').trigger('filter:clear');
        }
    });

    $('li[filter-name={{ str_slug($filter->name) }}]').on('filter:clear', function(e) {
        $('li[filter-name={{ $filter->name }}]').removeClass('active');
        $('#text-filter-{{ str_slug($filter->name) }}').val('');
    });

    // datepicker clear button
    $(".text-filter-{{ str_slug($filter->name) }}-clear-button").click(function(e) {
        e.preventDefault();

        $('li[filter-name={{ str_slug($filter->name) }}]').trigger('filter:clear');
        $('#text-filter-{{ str_slug($filter->name) }}').val('');
        $('#text-filter-{{ str_slug($filter->name) }}').trigger('change');
    })
});
    </script>
  @endpush
  {{-- End of Extra CSS and JS --}}
  {{-- ########################################## --}}
@php



@endphp
