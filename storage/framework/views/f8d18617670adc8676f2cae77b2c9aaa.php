<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    
    <?php echo $__env->make('admin.stylesheet', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body>
    
    <?php echo $__env->make('admin.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Right Panel -->
    <?php if(in_array('etemplate',$avilable)): ?>
    <div id="right-panel" class="right-panel">

        
                       <?php echo $__env->make('admin.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                       

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1><?php echo e(__('Email Template')); ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        
                    </div>
                </div>
            </div>
        </div>
        
         <?php echo $__env->make('admin.warning', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="content mt-3">
            <div class="animated fadeIn">
            
            <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title"><?php echo e(__('Email Template')); ?></strong>
                            </div>
                            <div class="card-body">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="10%"><?php echo e(__('Sno')); ?></th>
                                            <th width="40%"><?php echo e(__('Name')); ?></th>
                                            <th width="30%"><?php echo e(__('Subject')); ?></th>
                                            <th><?php echo e(__('Action')); ?></th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no = 1; ?>
                                    <?php $__currentLoopData = $templateData['view']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($no); ?></td>
                                            <td width="200"><?php echo e($template->et_heading); ?> </td>
                                            <td width="200"><?php echo e($template->et_subject); ?> </td>
                                            <td><a href="<?php echo e(url('/admin')); ?>/edit-email-template/<?php echo e($template->et_id); ?>" class="btn btn-success btn-sm"><i class="fa fa-edit"></i>&nbsp; <?php echo e(__('Edit')); ?></a> 
                                            </td>
                                        </tr>
                                        
                                        <?php $no++; ?>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>     
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

 
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->
    <?php else: ?>
    <?php echo $__env->make('admin.denied', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
    <!-- Right Panel -->


   <?php echo $__env->make('admin.javascript', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script type="text/javascript">
      $(document).ready(function () { 
    var oTable = $('#example').dataTable({
        stateSave: true,
		responsive: true,
		dom: 'Bfrtip',
        buttons: [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
					className: 'ml-4 mr-1',
					filename: '<?php echo e($allsettings->site_title); ?> - Email-template'
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
					className: 'mr-1',
					filename: '<?php echo e($allsettings->site_title); ?> - Email-template'
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
					className: 'mr-1',
					filename: '<?php echo e($allsettings->site_title); ?> - Email-template'
                },
				{
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
					className: 'mr-1',
					filename: '<?php echo e($allsettings->site_title); ?> - Email-template'
                },
				{
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
					className: 'mr-1',
					filename: '<?php echo e($allsettings->site_title); ?> - Email-template'
                }
                
            ]
    });

    
      


	
	
	});

</script>
</body>

</html>
<?php /**PATH /home/arixmyii/bittoz.shop/public_html/resources/views/admin/email-template.blade.php ENDPATH**/ ?>