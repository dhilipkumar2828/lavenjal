@if(session()->has('error'))
<script>
	custom_noty("error", "{{ Session::get('error') }}");
</script>
@endif

@if(session()->has('success'))
<script>
	custom_noty("success", "{{ Session::get('success') }}");
</script>
@endif

@if(session()->has('warning'))
<script>
	custom_noty("warning", "{{ Session::get('warning') }}");
</script>
@endif

@if(session()->has('alert'))
<script>
	custom_noty("alert", "{{ Session::get('alert') }}");
</script>
@endif

@if(session()->has('notification'))
<script>
	custom_noty("notification", "{{ Session::get('notification') }}");
</script>
@endif

@if(session()->has('info'))
<script>
	custom_noty("info", "{{ Session::get('info') }}");
</script>
@endif

@if(session()->has('information'))
<script>
	custom_noty("information", "{{ Session::get('information') }}");
</script>
@endif