<?php
namespace Ktpl\Brand\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
 
class MyActions extends Column
{
    /** Url path */
    const Employee_URL_PATH_EDIT = 'ktpl_brand/index/edit';
    const Employee_URL_PATH_DELETE = 'ktpl_brand/index/delete';
 
    /** @var UrlInterface */
    protected $urlBuilder;
 
    /**
     * @var string
     */
    private $editUrl;
 
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::Employee_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
 
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {  
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
               
                $name = $this->getData('name');
                if (isset($item['brand_id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['id' => $item['brand_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::Employee_URL_PATH_DELETE, ['id' => $item['brand_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "${ $.$data.brand_title }"'),
                            'message' => __('Are you sure you wan\'t to delete a "${ $.$data.brand_title }" record?')
                        ]
                    ];
                }
            }
        }
 
        return $dataSource;
    }
}