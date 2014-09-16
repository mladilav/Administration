<?php
/**
 * Created by PhpStorm.
 * User: Olga
 * Date: 16.09.14
 * Time: 11:17
 */

class Application_Model_Projects
{
    public function getProjects(){
        $projects = new Application_Model_DbTable_Projects();
        $project = $projects->fetchAll();
        $result = '<li class="dropdown-submenu">
                        <a tabindex="-1" href="#"><i class="icon-tasks"></i> Methods</a>
                            <ul class="dropdown-menu">';
        $project = $project->toArray();
        foreach($project as $proj){
            $result .=
                                '<li><a href="/method/index/project/'
                                .$proj['id']
                                .'">'
                                .$proj['name']
                                .'</a></li>';
        }
        $result .= '</ul></li>';
        return $result;
    }
}