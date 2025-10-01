<?php

namespace App\Services;

use Phpml\Estimator;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\Classification\SVC;
use Phpml\Tokenization\WordTokenizer;
use Phpml\SupportVectorMachine\Kernel;

class IntentModelWrapper implements Estimator
{
    public $vectorizer;
    public $transformer;
    public $classifier;
    
    public function __construct()
    {
        $this->vectorizer = new TokenCountVectorizer(new WordTokenizer());
        $this->transformer = new TfIdfTransformer();
        $this->classifier = new SVC(Kernel::RBF, 100);
    }
    
    public function train(array $samples, array $targets): void
    {
        $this->vectorizer->fit($samples);
        $this->vectorizer->transform($samples);
        
        $this->transformer->fit($samples);
        $this->transformer->transform($samples);
        
        $this->classifier->train($samples, $targets);
    }
    
    public function predict(array $samples)
    {
        $this->vectorizer->transform($samples);
        $this->transformer->transform($samples);
        return $this->classifier->predict($samples);
    }

    public function predictProbability(array $samples): array
        {
            $this->vectorizer->transform($samples);
            $this->transformer->transform($samples);
            
            if (method_exists($this->classifier, 'predictProbability')) {
                return $this->classifier->predictProbability($samples);
            }
            
            $predictions = $this->classifier->predict($samples);
            return array_map(fn($p) => [$p => 1.0], $predictions);
        }
}