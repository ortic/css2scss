<?php

namespace Ortic\Css2Scss;

use Ortic\Css2Scss\tokens\ScssRuleList;
use Ortic\Css2Scss\tokens\ScssRule;

class Css2Scss
{
    /**
     * @var string $cssContent
     */
    protected $cssContent;

    /**
     * @var \CssParser $parser
     */
    protected $parser;

    /**
     * Create a new parser object, use parameter to specify CSS you
     * wish to convert into a SCSS file
     *
     * @param string $cssContent
     */
    public function __construct($cssContent)
    {
        $this->cssContent = $cssContent;
        $this->parser = new \CssParser($this->cssContent);
    }

    /**
     * Returns a string containing the SCSS content matching the CSS input
     * @return string
     */
    public function getScss()
    {
        $scssTree = array();

        // this variable is true, if we're within a ruleset, e.g. p { .. here .. }
        // we have to normalize them
        $withinRulset = false;
        $ruleSet = null;
        $ruleSetList = new ScssRuleList();

        $tokens = $this->parser->getTokens();

        foreach ($tokens as $token) {
            // we have to skip some tokens, their information is redundant
            if ($token instanceof \CssAtMediaStartToken ||
                $token instanceof \CssAtMediaEndToken
            ) {
                continue;
            }

            // we have to build a hierarchy with CssRulesetStartToken, CssRulesetEndToken
            if ($token instanceof \CssRulesetStartToken) {
                $withinRulset = true;
                $ruleSet = new ScssRule($token->Selectors);
            } elseif ($token instanceof \CssRulesetEndToken) {
                $withinRulset = false;
                if ($ruleSet) {
                    $ruleSetList->addRule($ruleSet);
                }
                $ruleSet = null;
            } else {
                // as long as we're in a ruleset, we're adding all token to a custom array
                // this will be scssified once we've found CssRulesetEndToken and then added
                // to the actual $scssTree variable
                if ($withinRulset) {
                    $ruleSet->addToken($token);
                } else {
                    $scssTree[] = $token;
                }
            }
        }

        $return = '';
        foreach ($scssTree as $node) {
            // @TODO this format method shouldn't be in this class..
            $return .= $ruleSetList->formatTokenAsScss($node) . "\n";
        }

        $return .= $ruleSetList->scssify();

        return $return;
    }
}
