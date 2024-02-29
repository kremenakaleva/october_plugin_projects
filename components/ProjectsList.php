<?php namespace Pensoft\Projects\Components;

use Cms\Classes\ComponentBase;
use \Pensoft\Projects\Models\Project;
use RainLab\Translate\Classes\Translator;

/**
 * ProjectsList Component
 */
class ProjectsList extends ComponentBase
{
    public $records;
    public $translator;

    public function onRun()
    {
        $this->addJs('/plugins/pensoft/projects/assets/filter.js');
        $this->records = $this->searchRecords();
        $this->translator = Translator::instance();
        $this->page['records'] = $this->records;
        $this->page['lang'] = $this->translator->getLocale();
    }
    
    public function componentDetails()
    {
        return [
            'name' => 'Projects List',
            'description' => 'Search filter sort and display Project List records'
        ];
    }

    public function onSearchRecords() {
        $searchTerms = post('searchTerms');
        $sortField = post('sortField', 'title');
        $sortDirection = post('sortDirection', 'asc');
        $startDate = post('startDate');
        $endDate = post('endDate');
        $this->translator = Translator::instance();
        $this->page['records'] = $this->searchRecords($searchTerms, $sortField, $sortDirection, $startDate, $endDate);
        $this->page['lang'] = $this->translator->getLocale();
        return ['#recordsContainer' => $this->renderPartial('@records')];
    }
    
    protected function searchRecords(
        $searchTerms = '', 
        $sortField = 'title', 
        $sortDirection = 'asc', 
        $startDate = '', 
        $endDate = ''
    ) {
        $query = Project::query();
        
        if (!empty($searchTerms)) {
            $searchTerms = is_string($searchTerms) ? json_decode($searchTerms, true) : (array)$searchTerms;
    
            foreach ($searchTerms as $term) {
                if ($term) {
                    $translator = Translator::instance();
                    $locale = $translator->getLocale();
    
                    $keywordsField = $locale === 'bg' ? 'keywords_bg' : 'keywords_en';

                    $query->orWhere($keywordsField, 'LIKE', '%' . $term . '%');   
                }
            }   
        }
    
        $query->orderBy($sortField, $sortDirection);
    
        if ($startDate) {
            $query->whereDate('start', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('end', '<=', $endDate);
        }
    
        return $query->where('published', 'true')->get();
    }
    
    public function onGetKeywords()
    {
        $uniqueKeywords = Project::getKeywordsHighlights();
        return response()->json($uniqueKeywords);
    }

    public function defineProperties()
    {
        return [];
    }
}
