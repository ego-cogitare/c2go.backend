<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Podcast;
use App\Models\Category;
use App\Models\Question;
use App\Models\CategoryQuestion;
use App\Models\QuestionParam;
use Illuminate\Http\Response;

class PodcastController extends Controller
{
    private function getPodcastById($id, $type = Category::TYPE_CATEGORY) 
    {
        return Podcast::with([
            'categories' => function($query) use ($type) {
                $query->with([
                    'category_questions' => function($query) {
                        $query->with(['question'])->orderBy('order', 'ASC');
                    },
                    'question_params' => function($query) {

                    },
                ])
                ->where('type', $type)
                ->orderBy('order', 'ASC');
            }
        ])->find($id);
    }
    
    public function index(Request $request)
    {
        $podcast = Podcast::where(['enabled' => 1])
                ->orderBy('order', 'ASC')
                ->get();
        
        return new Response($podcast, 200);
    }
    
    public function show(Request $request, $id)
    {
        // Get podcast category type to fetch
        $type = intval($request->input('type'));
        
        if (!in_array($type, [Category::TYPE_CATEGORY, Category::TYPE_CRITERIA])) {
            $result = [
                'status' => false,
                'error' => 'Podcast category type incorrect'
            ];
            return new Response($result, 400);
        }
        
        $code = 200;
        $podcast = $this->getPodcastById($id, $type);
        
        if (!$podcast) {
            $result = [
                'status' => false,
                'error' => 'Podcast not found'
            ];
            $code = 404;
        } else {
            $result = [
                'status' => true,
                'podcast' => $podcast
            ];
        }

        return new Response($result, $code);
    }
    
    public function remove(Request $request, $id) {
        $podcast = Podcast::findOrFail($id)->delete();
        
        $result = [
            'status' => true,
        ];
        
        return new Response($result, 203);
    }
    
    public function update(Request $request, $id)
    {
        $podcast_json = $request->input('podcast');
        
        $code = 200;
        $result = [
            'status' => true,
        ];
        
        if (empty($podcast_json)) {
            $code = 400;
            $result = [
                'status' => true,
                'error' => 'Podcast json can not be empty string'
            ];
        }
        
        /**
         * Podcast update steps:
         *  1. Update existing or create a new one podcast
         *  2. Delete all categories which is no exists in podcast identity
         *  3. Update existing or create a new categories
         */
        
        // Podcast JSON evaluating
        $podcast_identity = \GuzzleHttp\json_decode($podcast_json);
        
        /**
         *  1-st STEP:
         *  Podcast update
         */
        
        // Podcast information to update
        $podcast_data =  [
            'name'    => $podcast_identity->name,
            'enabled' => $podcast_identity->enabled,
            'order'   => $podcast_identity->order
        ];
        
        // Get existing podcast or create a new one
        $podcast = Podcast::firstOrCreate(['id' => $podcast_identity->id]);
        
        // Fill podcast fields
        $podcast->fill($podcast_data);
        
        // Update podcast information
        $podcast->save();
        
        
        /**
         *  2-nd STEP:
         *  Delete all categories which is on exists in json
         */
        
        // Collect all categories IDs
        $category_ids = array_map(
            function($category) {
                return $category->id; 
            },
            $podcast_identity->categories
        );
            
        // Remove all categories which is in the podcast and not in $category_ids list
        if (sizeof($podcast_identity->categories) > 0)
        {
            Category::where([
                'podcast_id' => $podcast_identity->id, 
                'type' => $podcast_identity->categories[0]->type
            ])
            ->whereNotIn('id', $category_ids)
            ->delete();
        }
        
        /**
         *  3-rd STEP:
         *  Update existing or create a new categories
         */
        foreach ($podcast_identity->categories as $category_item) 
        {
            $category_data =  [
                'name'       => $category_item->name,
                'podcast_id' => $podcast->id,
                'enabled'    => $category_item->enabled,
                'order'      => $category_item->order,
                'type'       => $category_item->type,
                'icon'       => $category_item->icon,
            ];
            
            $category = Category::firstOrCreate(['id' => $category_item->id]);
            $category->fill($category_data);
            $category->save();
            
            // Deleting all question_params and category_questions for the
            // category and questions which is not in the category anymore
            /*$question_ids = array_map(
                function($question) {
                    return $question->id;
                },
                $category_item->category_questions
            );*/
                
            CategoryQuestion::where(['category_id' => $category->id])
                //->whereNotIn('question_id', $question_ids)
                ->delete();
            
            QuestionParam::where(['category_id' => $category->id])
                //->whereNotIn('question_id', $question_ids)
                ->delete();
            
            // Create new question records or update existing
            foreach ($category_item->category_questions as $category_question) 
            {
                $is_custom_question = $category_question->question->type == 3;
                
                if ($is_custom_question)
                {
                    // Search custom question record
                    $question = Question::where('id', $category_question->question->id)->first();
                    
                    // List of questions to update category parameters
                    $questions_list = $question->questions;
                }
                else 
                {
                    $question_data = [
                        'name'        => $category_question->question->name,
                        'type'        => $category_question->question->type,
                        'parent_id'   => $category_question->question->parent_id,
                        'custom_type' => $category_question->question->custom_type,
                    ];
                    $question = Question::firstOrCreate(['id' => $category_question->question->id]);
                    
                    // Save question if question marked as new
                    if (isset($category_question->question->isNew) && $category_question->question->isNew) {
                        $question->fill($question_data);
                        $question->save();
                    }
                    $questions_list = [$question];
                }
                
                foreach ($questions_list as $q) 
                {
                    // Add question params data
                    $question_params = array_filter(
                        $category_item->question_params,
                        function($param) use ($category_question, $q, $is_custom_question) {
                            if ($is_custom_question) {
                                return ($param->question_id === $q->id) &&
                                       ($param->category_id === $category_question->category_id);
                            } else {
                                return ($param->question_id === $category_question->question->id) &&
                                       ($param->category_id === $category_question->category_id);
                            }
                        }
                    );

                    $params_list = [];
                    if (sizeof($question_params) > 0) {
                        array_walk(
                            $question_params,
                            function($param) use (&$params_list) {
                                $params_list[$param->name] = empty($param->value) ? null : $param->value;
                            }
                        );
                    }
                    
                    \App\Models\QuestionParam::setParams(
                        $params_list, 
                        $category->id, 
                        $q->id
                    );
                }
                
                // Add category question data
                CategoryQuestion::create([
                    'category_id' => $category->id,
                    'question_id' => $question->id,
                    'order'       => $category_question->order
                ]);
            }
        }
        
        return new Response($result, $code);
    }
}