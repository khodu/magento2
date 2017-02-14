<?php
namespace Pulsestrom\ToDoCrud\Ui\Component\Listing\Column\Pulsestormtodolisting;

class PageActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource["data"]["items"])) {
            foreach ($dataSource["data"]["items"] as & $item) {
                $name = $this->getData("name");
                $id = "X";
                if(isset($item["pulsestorm_todocrud_todoitem_id"]))
                {
                    $id = $item["pulsestorm_todocrud_todoitem_id"];
                }
                $item[$name]["view"] = [
                    "href"=>$this->getContext()->getUrl(
                        "adminhtml/pulsestorm_todo_listing/viewlog",["id"=>$id]),
                    "label"=>__("Edit")
                ];
            }
        }

        return $dataSource;
    }    
    
}
