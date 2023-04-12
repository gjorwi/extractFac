<div class="d-flex flex-column  p-5 w-75" >
	<div class="d-flex bg-primary text-white m-2 rounded-2" >
		<div class="w-100">
	 		<div class="h-100  mt-2 ps-2"><?php if ( $error!=null ){ echo $error;}?></div>
	 	</div>
		<div class="flex-shrink-1">
		<?php if ( $error!=null ):?>
			<a class="btn mt-n2 bg-light text-black my-1 me-2 " href="<?php echo base_url()?>readimg">ok</a>
		<?php endif; ?>
		</div>
	</div>
	<div id="container" class="container card d-flex justify-content-center align-items-center " >
		<h1>Bienvenidos a Extract Invoices</h1>
		
		<?php echo form_open_multipart('readimg/extract')?>
		<div class="d-flex ">
			<div class="col-auto">
				<input type="file" class="form-control" name="file" placeholder="File">
			</div>
			<div class="col-auto">
				<button type="submit" class="btn btn-primary mb-3 ms-2">Extract DATA</button>
			</div>
		</div>
		<?php echo form_close()?>
			
		
	</div>
</div>