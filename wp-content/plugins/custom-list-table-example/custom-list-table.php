<?php


/* 

BASE TEMPLATE CODE TAKEN FROM https://wordpress.org/plugins/custom-list-table-example/
AND ADAPTED TO INCLUDE AN EXTERNAL DATABASE AND AN AJAX CALL TO UPDATE IT ASYNCHRONOUSLY.


*/
	


if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}




class Enquiry_List_Table extends WP_List_Table {
    

    var $example_data = array();


    function __construct() {

		global $status, $page, $wpdb;

		this.$example_data = $wpdb->query('SELECT * FROM enquiry_info', ARRAY_A );
        
		//Set parent defaults
		parent::__construct(
            
			array(
                
				//singular name of the listed records
				'singular'	=> 'enquiry',
                
				//plural name of the listed records
				'plural'	=> 'enquiries',
                
				//does this table support ajax?
				'ajax'		=> true
                
			)
		);
		
	}


    function column_default( $item, $column_name ) {

		$rendered_column = '';

		switch ( $column_name ) {

			case 'status':
			
				$status_array = array('Awaiting','Responded','Confirmed','Completed');
				
				$rendered_column .= '<select style="width:100%" class="status">';
			
				foreach ( $status_array as $key => $value ) {
					
					$optionSelectedHtml = '';
					
					if ( $item['status'] == $key ) {
									
						$optionSelectedHtml = 'selected';
											
					}
					
					$rendered_column .= '<option value="' . $key . '" '. $optionSelectedHtml .'>' . $value . '</option>';
					
				}

				$rendered_column .= '</select>';
								
				break;

			default:
			
				$rendered_column = $item[ $column_name ];
				
				break;

		}
		
		return $rendered_column;

	}

    function column_title($item){
        
        //Build row actions
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&movie=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&movie=%s">Delete</a>',$_REQUEST['page'],'delete',$item['ID']),
        );
        
        //Return the title contents
        return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
            /*$1%s*/ $item['title'],
            /*$2%s*/ $item['ID'],
            /*$3%s*/ $this->row_actions($actions)
        );
    }

    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movie")
            /*$2%s*/ $item['ID']                //The value of the checkbox should be the record's id
        );
    }

    function get_columns() {

		return $columns = array(
            
			'cb'				=> '<input type="checkbox" />', //Render a checkbox instead of text
			'id'				=> 'ID',
			'name'				=> 'Name',
			'email'				=> 'Email',
			'description'		=> 'Description',
			'start_date'		=> 'Start Date',
			'launch_date'		=> 'Launch Date',
			'budget'			=> 'Budget',
			'business_name'		=> 'Business Name',
			'website'			=> 'Website',
			'project_type'		=> 'Project Type',
			'phone'				=> 'Phone',
			'status'			=> 'Status'
            
		);
	}

    function get_sortable_columns() {

		return $sortable_columns = array(
            
			'name'	 	=> array( 'name', false ),	//true means it's already sorted
            
			'start_date'	=> array( 'start_date', false ),
            
			'launch_date'	=> array( 'launch_date', false ),
            
			'id'	 	=> array( 'id', false ),	//true means it's already sorted
            
			'project_type'	=> array( 'project_type', false ),
            
			'status'	=> array( 'status', false )
		);
	}

    // Currently not functioning correctly... 
    
    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
        
    }

    function prepare_items() {
        global $wpdb; //This is used only if making any database queries
		
		$results = $wpdb->get_results( 'SELECT * FROM wp_enquiryinfo' , ARRAY_A );

        /**
         * First, lets decide how many records per page to show
         */
        $per_page = 10;
        
        
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        $this->_column_headers = array($columns, $hidden, $sortable);
        

        $this->process_bulk_action();
        
        $data = $results;

        function usort_reorder($a,$b){
            $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'title'; //If no sort, default to title
            $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
            $result = strcmp($a[$orderby], $b[$orderby]); //Determine sort order
            return ($order==='asc') ? $result : -$result; //Send final sort direction to usort
        }
        usort($data, 'usort_reorder');
        

        $current_page = $this->get_pagenum();
        

        $total_items = count($data);
        
        
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        
        
        $this->items = $data;
        
        
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }


}

/***************************** REGISTER PAGE ***********************************/

function tt_add_menu_items(){
    add_menu_page('Example Plugin List Table', 'List Table Example', 'activate_plugins', 'tt_list_test', 'tt_render_list_page');
} add_action('admin_menu', 'tt_add_menu_items');


/****************************** RENDER PAGE ************************************/

function tt_render_list_page(){
    
    //Create an instance of our package class...
    $testListTable = new Enquiry_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $testListTable->prepare_items();
    
    ?>
    <div class="wrap">
        
        <div id="icon-users" class="icon32"><br/></div>
        <h2>List Table Test</h2>
        
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>This page demonstrates the use of the <tt><a href="http://codex.wordpress.org/Class_Reference/WP_List_Table" target="_blank" style="text-decoration:none;">WP_List_Table</a></tt> class in plugins.</p> 
            <p>For a detailed explanation of using the <tt><a href="http://codex.wordpress.org/Class_Reference/WP_List_Table" target="_blank" style="text-decoration:none;">WP_List_Table</a></tt>
            class in your own plugins, you can view this file <a href="<?php echo admin_url( 'plugin-editor.php?plugin='.plugin_basename(__FILE__) ); ?>" style="text-decoration:none;">in the Plugin Editor</a> or simply open <tt style="color:gray;"><?php echo __FILE__ ?></tt> in the PHP editor of your choice.</p>
            <p>Additional class details are available on the <a href="http://codex.wordpress.org/Class_Reference/WP_List_Table" target="_blank" style="text-decoration:none;">WordPress Codex</a>.</p>
        </div>
        
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="movies-filter" method="get"> 

            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $testListTable->display() ?>

        </form>
        
    </div>

     <script>

        jQuery('select.status').on('change', function() {
            
            alert("got in here!");

            var enquiryStatusValue = jQuery(this).val();

            jQuery.ajax({

                type: "POST",

                url: "/wp-admin/admin-ajax.php",

                data: enquiryStatusValue,

                success: function() {

                    alert("SUCCESSFUL!");

                },

                error: function() {

                    alert("FAILED!!");

                }
                
            });

        })

    </script>

	<?php
	
}

	
add_action('wp_ajax_addCustomer', 'addCustomer');