<?php
namespace Modules\Frontend\Controller;

use Flexi\Http\Redirect;
use Flexi\Template\View;
use Modules\Frontend\Model;

/**
 * Class ResourceController
 * @package Modules\Frontend\Controller
 */
class ResourceController extends FrontendController
{
    /**
     * @var Model\Resource
     */
    protected $resourceModel;

    /**
     * PageController constructor.
     */
    public function __construct()
    {
        $this->resourceModel = new Model\Resource();

        parent::__construct();
    }

    /**
     * @param string $resourceType
     * @param $segment
     * @return View
     */
    public function show(string $resourceType, $segment)
    {
        $resource = $this->resourceModel->getResourceBySegment($segment);

        if ($resource->getAttribute('status') !== 'publish') {
            Redirect::go('/');
        }

        $templateName = $resourceType;

        if ($resource->getAttribute('type') !== 'basic') {
            $templateName .= '.' . $resource->getAttribute('type');
        }

        //print_r($resource);

        //print_r($this->data);


        $this->setData('type', $resourceType);
        $this->setData($resourceType, $resource);

        return View::make($templateName, $this->data);
    }
}
