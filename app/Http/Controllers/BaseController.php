<?php
use App\Http\Controllers\Controller;

class BaseController extends Controller {
	protected $layout = 'layouts.public';
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function callAction($method, $parameters)
	{
		$this->setupLayout();
		$response = call_user_func_array(array($this, $method), $parameters);
		// If no response is returned from the controller action and a layout is being
		// used we will assume we want to just return the layout view as any nested
		// views were probably bound on this view during this controller actions.
		if (is_null($response) && ! is_null($this->layout))
		{
			$response = $this->layout;
		}
		return $response;
	}

	// protected function setPageContent($content)
	// 	{
	// 	    return view($this->layout, ['content' => $content]);
	// 	}

	
	// get items attribute 
	// Input: array of items object
	// Output: array of items attributes
	protected function getItemAttributes($items){
		$items_attr  = array();
		foreach ($items as $item) {
			$values = Value::where('item_id', $item->id)->get();
			foreach ($values as $value) {
				$attr_name = Attribute::find($value->attr_id)->attr_name;
				$items_attr[$item->id][$attr_name] = $value->value;
			}
		}
		return $items_attr;
	}
	
	// get item attribute 
	// Input: item object
	// Output: array of one item attributes
    protected function getOneItemAttributes($item){
		$items_attr  = array();
		$values = Value::where('item_id', $item->id)->orderBy('attr_id')->get();
		if ($values->isEmpty()) {
			return null;
		}else{
			foreach ($values as $value) {
				$attr_id = $value->attr_id;
				$attr = Attribute::find($attr_id);
				$attr_name = $attr->attr_name;
				$item_attr[$attr_id] = $value->value;
			}
			return $item_attr;
		}
	}

	public function getAttributeOption(){
		$item_attr_option = array();
		$attrs = Attribute::all();
		foreach ($attrs as $attr) {
			$attr_name = $attr->attr_name;
			$attr_id = $attr->id;
			$attr_option_array = Value::where('attr_id',$attr_id)->distinct()->get(array('value'))->toArray();
			$item_attr_option[$attr_id] = $attr_option_array;
		}
		return $item_attr_option;
	}

	public function getOneAttributeOption($attr_id){
		$attr_option = Value::where('attr_id',$attr_id)->distinct()->get(array('value'))->toArray();
		return $attr_option;
	}

	public function getAttributeType(){
		$item_attr_type = array();
		$attrs = Attribute::all();
		foreach ($attrs as $attr) {
			$attr_name = $attr->attr_name;
			$attr_type = $attr->attr_type;
			$item_attr_type[$attr_name] = $attr_type;
		}
		return $item_attr_type;
	}

	public function getItemsVote($items){
		$item_vote_array = array();
		foreach ($items as $item) {
			$item_vote_array[$item->id]['good'] = Vote::where(array(
																'item_id' => $item->id,
																'type' => 1
																))->count();
			$item_vote_array[$item->id]['bad'] = Vote::where(array(
																'item_id' => $item->id,
																'type' => 2
																))->count();
		}
		return $item_vote_array;
	}
}
