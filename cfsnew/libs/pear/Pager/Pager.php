<?php
// +-----------------------------------------------------------------------+
// | Copyright (c) 2002-2003, Richard Heyes                                     |
// | All rights reserved.                                                  |
// |                                                                       |
// | Redistribution and use in source and binary forms, with or without    |
// | modification, are permitted provided that the following conditions    |
// | are met:                                                              |
// |                                                                       |
// | o Redistributions of source code must retain the above copyright      |
// |   notice, this list of conditions and the following disclaimer.       |
// | o Redistributions in binary form must reproduce the above copyright   |
// |   notice, this list of conditions and the following disclaimer in the |
// |   documentation and/or other materials provided with the distribution.|
// | o The names of the authors may not be used to endorse or promote      |
// |   products derived from this software without specific prior written  |
// |   permission.                                                         |
// |                                                                       |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR |
// | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  |
// | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, |
// | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT      |
// | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, |
// | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY |
// | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT   |
// | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE |
// | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  |
// |                                                                       |
// +-----------------------------------------------------------------------+
// | Author: Richard Heyes <richard@phpguru.org>                           |
// +-----------------------------------------------------------------------+
//
// $Id: Pager.php,v 1.10 2003/06/07 15:46:48 quipo Exp $

/**
* Pager class
*
* Handles paging a set of data. For usage see the example.php provided.
*
*/
class Pager {
    /**
    * CSS class of the links
    * @var string
    */
    var $_linkClass;

    /**
    * Current page
    * @var integer
    */
    var $_currentPage;

    /**
    * Items per page
    * @var integer
    */
    var $_perPage;

    /**
    * Total number of pages
    * @var integer
    */
    var $_totalPages;

    /**
    * Item data. Numerically indexed array...
    * @var array
    */
    var $_itemData;

    /**
    * Total number of items in the data
    * @var integer
    */
    var $_totalItems;

    /**
    * Page data generated by this class
    * @var array
    */
    var $_pageData;

    /**
    * Constructor
    *
    * Sets up the object and calculates the total number of items.
	* One of either totalItems OR itemData MUST be supplied.
    *
    * @param $params An associative array of parameters This can contain:
    *                  currentPage   Current Page number (optional)
    *                  perPage       Items per page (optional)
    *                  linkClass     CSS class of the links (optional)
    *                  itemData      Array of data to page
	*                  totalItems    Total number of items
    */
    function pager($params = array())
    {
        global $HTTP_GET_VARS;

        $this->_currentPage = max((int)@$HTTP_GET_VARS['pageID'], 1);
        $this->_perPage     = 10;
        $this->_itemData    = null;

        foreach ($params as $name => $value) {
            $this->{'_' . $name} = $value;
        }

		// Been supplied an array of data ?
        if ($this->_itemData !== null) {
            $this->_totalItems = count($this->_itemData);
        }
        $this->_generatePageData();
    }

    /**
    * Returns an array of current pages data
    *
    * @param $pageID Desired page ID (optional)
    * @return array Page data
    */
    function getPageData($pageID = null)
    {
        if (isset($pageID)) {
            if (!empty($this->_pageData[$pageID])) {
                return $this->_pageData[$pageID];
            } else {
                return FALSE;
            }
        }

        if (!isset($this->_pageData)) {
            $this->_generatePageData();
        }

        return $this->getPageData($this->_currentPage);
    }

    /**
    * Returns pageID for given offset
    *
    * @param $index Offset to get pageID for
    * @return int PageID for given offset
    */
    function getPageIdByOffset($index)
    {
        if (!isset($this->_pageData)) {
            $this->_generatePageData();
        }

        if (($index % $this->_perPage) > 0) {
            $pageID = ceil((float)$index / (float)$this->_perPage);
        } else {
            $pageID = $index / $this->_perPage;
        }

        return $pageID;
    }

    /**
    * Returns offsets for given pageID. Eg, if you
    * pass it pageID one and your perPage limit is 10
    * it will return you 1 and 10. PageID of 2 would
    * give you 11 and 20.
    *
    * @param pageID PageID to get offsets for
    * @return array  First and last offsets
    */
    function getOffsetByPageId($pageid = null)
    {
        $pageid = isset($pageid) ? $pageid : $this->_currentPage;
        if (!isset($this->_pageData)) {
            $this->_generatePageData();
        }

        if (isset($this->_pageData[$pageid]) OR $this->_itemData === null) {
            return array(($this->_perPage * ($pageid - 1)) + 1, min($this->_totalItems, $this->_perPage * $pageid));
        } else {
            return array(0,0);
        }
    }

    /**
    * Returns back/next and page links
    *
    * @param  $back_html HTML to put inside the back link
    * @param  $next_html HTML to put inside the next link
    * @return array Back/pages/next links
    */
    function getLinks($back_html = '<< Back', $next_html = 'Next >>')
    {
        $url   = $this->_getLinksUrl();
        $back  = $this->_getBackLink($url, $back_html);
        $pages = $this->_getPageLinks($url);
        $next  = $this->_getNextLink($url, $next_html);

        return array($back, $pages, $next, 'back' => $back, 'pages' => $pages, 'next' => $next);
    }

    /**
    * Returns ID of current page
    *
    * @return integer ID of current page
    */
    function getCurrentPageID()
    {
        return $this->_currentPage;
    }

	/**
    * Returns next page ID. If current page is last page
	* this function returns FALSE
	*
	* @return mixed Next pages' ID
    */
	function getNextPageID()
	{
		return ($this->getCurrentPageID() == $this->numPages() ? false : $this->getCurrentPageID() + 1);
	}

	/**
    * Returns previous page ID. If current page is first page
	* this function returns FALSE
	*
	* @return mixed Previous pages' ID
    */
	function getPreviousPageID()
	{
		return $this->isFirstPage() ? false : $this->getCurrentPageID() - 1;
	}

    /**
    * Returns number of items
    *
    * @return int Number of items
    */
    function numItems()
    {
        return $this->_totalItems;
    }

    /**
    * Returns number of pages
    *
    * @return int Number of pages
    */
    function numPages()
    {
        return (int)$this->_totalPages;
    }

    /**
    * Returns whether current page is first page
    *
    * @return bool First page or not
    */
    function isFirstPage()
    {
        return ($this->_currentPage == 1);
    }

    /**
    * Returns whether current page is last page
    *
    * @return bool Last page or not
    */
    function isLastPage()
    {
        return ($this->_currentPage == $this->_totalPages);
    }

    /**
    * Returns whether last page is complete
    *
    * @return bool Last age complete or not
    */
    function isLastPageComplete()
    {
        return !($this->_totalItems % $this->_perPage);
    }

    /**
    * Calculates all page data
    */
    function _generatePageData()
    {
        if ($this->_itemData !== null) {
            $this->_totalItems = count($this->_itemData);
        }
        $this->_totalPages = ceil((float)$this->_totalItems / (float)$this->_perPage);
        $i = 1;
        if (!empty($this->_itemData)) {
            foreach ($this->_itemData as $key => $value) {
                $this->_pageData[$i][$key] = $value;
                if (count($this->_pageData[$i]) >= $this->_perPage) {
                    $i++;
                }
            }
        } else {
            $this->_pageData = array();
        }

        //prevent URL modification
        $this->_currentPage = min($this->_currentPage, $this->_totalPages);
    }

    /**
    * Returns the correct link for the back/pages/next links
    *
    * @return string Url
    */
    function _getLinksUrl()
    {
        global $HTTP_SERVER_VARS;

        // Sort out query string to prevent messy urls
        $querystring = array();
        $qs = array();
        if (!empty($HTTP_SERVER_VARS['QUERY_STRING'])) {
            $qs = explode('&', $HTTP_SERVER_VARS['QUERY_STRING']);
            for ($i = 0, $cnt = count($qs); $i < $cnt; $i++) {
                list($name, $value) = explode('=', $qs[$i]);
                if ($name != 'pageID') {
                    $qs[$name] = $value;
                }
                unset($qs[$i]);
            }
        }

        foreach ($qs as $name => $value) {
            $querystring[] = $name . '=' . $value;
        }

        return $HTTP_SERVER_VARS['PHP_SELF'] . '?' . implode('&', $querystring) . (!empty($querystring) ? '&' : '') . 'pageID=';
    }

    /**
    * Returns back link
    *
    * @param $url  URL to use in the link
    * @param $link HTML to use as the link
    * @return string The link
    */
    function _getBackLink($url, $link = '<< Back')
    {
        // Back link
        if ($this->_currentPage > 1) {
            $back = sprintf('<a href="%s%d" %s>%s</a>',
                            $url,
                            $this->_currentPage - 1,
                            !empty($this->_linkClass) ? 'class="' . $this->_linkClass . '"' : '',
                            $link);
        } else {
            $back = '';
        }

        return $back;
    }

    /**
    * Returns pages link
    *
    * @param $url  URL to use in the link
    * @return string Links
    */
    function _getPageLinks($url)
    {
        // Create the range
        $params['itemData'] = range(1, max(1, $this->_totalPages));
        $pager =& new Pager($params);
        $links =  $pager->getPageData($pager->getPageIdByOffset($this->_currentPage));

        foreach ($links as $key => $value) {
            if ($links[$key] != $this->_currentPage) {
                $links[$key] = sprintf('<a href="%s%d" %s>%d</a>',
                                       $url,
                                       $links[$key],
                                       !empty($this->_linkClass) ? 'class="' . $this->_linkClass . '"' : '',
                                       $links[$key]);
            }
        }

        return implode(' ', $links);
    }

    /**
    * Returns next link
    *
    * @param $url  URL to use in the link
    * @param $link HTML to use as the link
    * @return string The link
    */
    function _getNextLink($url, $link = 'Next >>')
    {
        if ($this->_currentPage < $this->_totalPages) {
            $next = sprintf('<a href="%s%d" %s>%s</a>',
                            $url,
                            $this->_currentPage + 1,
                            !empty($this->_linkClass) ? 'class="' . $this->_linkClass . '"' : '',
                            $link);
        } else {
            $next = '';
        }

        return $next;
    }
}

?>