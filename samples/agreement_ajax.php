<?php
include_once '../class/cls_agreement_model.php';

                        $agreement_obj = new agreement_model();
                        $parent_nodes = $agreement_obj->getParentNodes();

                        if (count($parent_nodes) > 0) {
                            foreach ($parent_nodes as $parent_node) {
                                $agreement_obj = new agreement_model($parent_node['id']);
                                $agreement_file_count = $agreement_obj->getFiles();
                                if (count($agreement_file_count) > 0) {
                                    $icon = "&nbsp;&nbsp;&nbsp;<i class='fa fa-file' style='font-size:15px;color:blue;' onclick='addHandler(".$parent_node['id'].")'></i>";
                                } else {
                                    $icon = "&nbsp;&nbsp;&nbsp;<i class='fa fa-file' style='font-size:15px;color:green;' onclick='addHandler(".$parent_node['id'].")'></i>";
                                }

                                $sub_child_html_main = process_sub_nav_node($parent_node['id']);

                                print "<ul>"
                                        . "<li>"
                                        . "<span class=''>" . $parent_node['name'] . " &nbsp;<i class='fa fa-plus' style='font-size:15px;color:green;cursor:pointer;' onclick='addHandlerNode(".$parent_node['id'].")'></i>$icon</span>"                                        
                                        . "$sub_child_html_main"                                     
                                        . "</li>"
                                        . "</ul>";
                        }}
                        
                        function process_sub_nav_node($parent_model_id) {
//                            $tree_node_obj = new tree_node($parent_model_id);
                            $agreement_obj = new agreement_model($parent_model_id);

                            $child_nodes = $agreement_obj->getChild();
//                            print_r($child_nodes);
                            if (count($child_nodes) > 0) {
                                $html = "<ul>";
                                foreach ($child_nodes as $node) {  
                                    $agreement_obj = new agreement_model($node->id);
                                    $child_files = $agreement_obj->getFiles();

                                    if (count($child_files) > 0) {
                                        $icon = "&nbsp;&nbsp;&nbsp;<i class='fa fa-file' style='font-size:15px;cursor:pointer;color:blue;' onclick='addHandler($node->id)'></i>";
                                    } else {
                                        $icon = "&nbsp;&nbsp;&nbsp;<i class='fa fa-file' style='font-size:15px;cursor:pointer;color:green;' onclick='addHandler($node->id)'></i>";
                                    }
                                    
                                    $sub_child_html = process_sub_nav_node($node->id);

                                    $html .= "<li>"
                                            . "<span class=''>$node->name&nbsp;<i class='fa fa-cog' style='font-size:15px;cursor:pointer;' onclick='editHandler($node->id)'></i>$icon</span>"
                                            . $sub_child_html              
                                            . "</li>";
                                }
                                $html .= "</ul>";
                            }
                            return $html;
                        }

?>                        