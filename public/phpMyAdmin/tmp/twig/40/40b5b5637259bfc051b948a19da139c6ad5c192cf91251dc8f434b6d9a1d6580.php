<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* database/tracking/tables.twig */
class __TwigTemplate_c81465ab330544c2fb2b753997de264b69a6781f16d2ac562924311f00a6839b extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 2
        if (($context["head_version_exists"] ?? null)) {
            // line 3
            echo "    <div id=\"tracked_tables\">
        <h3>";
            // line 4
            echo _gettext("Tracked tables");
            echo "</h3>

        <form method=\"post\" action=\"db_tracking.php\" name=\"trackedForm\"
            id=\"trackedForm\" class=\"ajax\">
            ";
            // line 8
            echo PhpMyAdmin\Url::getHiddenInputs(($context["db"] ?? null));
            echo "
            <table id=\"versions\" class=\"data\">
                <thead>
                    <tr>
                        <th></th>
                        <th>";
            // line 13
            echo _gettext("Table");
            echo "</th>
                        <th>";
            // line 14
            echo _gettext("Last version");
            echo "</th>
                        <th>";
            // line 15
            echo _gettext("Created");
            echo "</th>
                        <th>";
            // line 16
            echo _gettext("Updated");
            echo "</th>
                        <th>";
            // line 17
            echo _gettext("Status");
            echo "</th>
                        <th>";
            // line 18
            echo _gettext("Action");
            echo "</th>
                        <th>";
            // line 19
            echo _gettext("Show");
            echo "</th>
                    </tr>
                </thead>
                <tbody>
                    ";
            // line 23
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["versions"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["version"]) {
                // line 24
                echo "                        <tr>
                            <td class=\"center\">
                                <input type=\"checkbox\" name=\"selected_tbl[]\"
                                    class=\"checkall\" id=\"selected_tbl_";
                // line 27
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["version"], "table_name", [], "any", false, false, false, 27), "html", null, true);
                echo "\"
                                    value=\"";
                // line 28
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["version"], "table_name", [], "any", false, false, false, 28), "html", null, true);
                echo "\">
                            </td>
                            <th>
                                <label for=\"selected_tbl_";
                // line 31
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["version"], "table_name", [], "any", false, false, false, 31), "html", null, true);
                echo "\">
                                    ";
                // line 32
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["version"], "table_name", [], "any", false, false, false, 32), "html", null, true);
                echo "
                                </label>
                            </th>
                            <td class=\"right\">
                                ";
                // line 36
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["version"], "version", [], "any", false, false, false, 36), "html", null, true);
                echo "
                            </td>
                            <td>
                                ";
                // line 39
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["version"], "date_created", [], "any", false, false, false, 39), "html", null, true);
                echo "
                            </td>
                            <td>
                                ";
                // line 42
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["version"], "date_updated", [], "any", false, false, false, 42), "html", null, true);
                echo "
                            </td>
                            <td>
                                ";
                // line 45
                echo twig_get_attribute($this->env, $this->source, $context["version"], "status_button", [], "any", false, false, false, 45);
                echo "
                            </td>
                            <td>
                                <a class=\"delete_tracking_anchor ajax\" href=\"db_tracking.php\" data-post=\"";
                // line 49
                echo PhpMyAdmin\Url::getCommon(["db" =>                 // line 50
($context["db"] ?? null), "goto" => "tbl_tracking.php", "back" => "db_tracking.php", "table" => twig_get_attribute($this->env, $this->source,                 // line 53
$context["version"], "table_name", [], "any", false, false, false, 53), "delete_tracking" => true], "");
                // line 55
                echo "\">
                                    ";
                // line 56
                echo PhpMyAdmin\Util::getIcon("b_drop", _gettext("Delete tracking"));
                echo "
                                </a>
                            </td>
                            <td>
                                <a href=\"tbl_tracking.php\" data-post=\"";
                // line 61
                echo PhpMyAdmin\Url::getCommon(["db" =>                 // line 62
($context["db"] ?? null), "goto" => "tbl_tracking.php", "back" => "db_tracking.php", "table" => twig_get_attribute($this->env, $this->source,                 // line 65
$context["version"], "table_name", [], "any", false, false, false, 65)], "");
                // line 66
                echo "\">
                                    ";
                // line 67
                echo PhpMyAdmin\Util::getIcon("b_versions", _gettext("Versions"));
                echo "
                                </a>
                                <a href=\"tbl_tracking.php\" data-post=\"";
                // line 70
                echo PhpMyAdmin\Url::getCommon(["db" =>                 // line 71
($context["db"] ?? null), "goto" => "tbl_tracking.php", "back" => "db_tracking.php", "table" => twig_get_attribute($this->env, $this->source,                 // line 74
$context["version"], "table_name", [], "any", false, false, false, 74), "report" => true, "version" => twig_get_attribute($this->env, $this->source,                 // line 76
$context["version"], "version", [], "any", false, false, false, 76)], "");
                // line 77
                echo "\">
                                    ";
                // line 78
                echo PhpMyAdmin\Util::getIcon("b_report", _gettext("Tracking report"));
                echo "
                                </a>
                                <a href=\"tbl_tracking.php\" data-post=\"";
                // line 81
                echo PhpMyAdmin\Url::getCommon(["db" =>                 // line 82
($context["db"] ?? null), "goto" => "tbl_tracking.php", "back" => "db_tracking.php", "table" => twig_get_attribute($this->env, $this->source,                 // line 85
$context["version"], "table_name", [], "any", false, false, false, 85), "snapshot" => true, "version" => twig_get_attribute($this->env, $this->source,                 // line 87
$context["version"], "version", [], "any", false, false, false, 87)], "");
                // line 88
                echo "\">
                                    ";
                // line 89
                echo PhpMyAdmin\Util::getIcon("b_props", _gettext("Structure snapshot"));
                echo "
                                </a>
                            </td>
                        </tr>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['version'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 94
            echo "                </tbody>
            </table>
            ";
            // line 96
            $this->loadTemplate("select_all.twig", "database/tracking/tables.twig", 96)->display(twig_to_array(["pma_theme_image" =>             // line 97
($context["pma_theme_image"] ?? null), "text_dir" =>             // line 98
($context["text_dir"] ?? null), "form_name" => "trackedForm"]));
            // line 101
            echo "            ";
            echo PhpMyAdmin\Util::getButtonOrImage("submit_mult", "mult_submit", _gettext("Delete tracking"), "b_drop", "delete_tracking");
            // line 107
            echo "
        </form>
    </div>
";
        }
        // line 111
        if (($context["untracked_tables_exists"] ?? null)) {
            // line 112
            echo "    <h3>";
            echo _gettext("Untracked tables");
            echo "</h3>
    <form method=\"post\" action=\"db_tracking.php\" name=\"untrackedForm\"
        id=\"untrackedForm\" class=\"ajax\">
        ";
            // line 115
            echo PhpMyAdmin\Url::getHiddenInputs(($context["db"] ?? null));
            echo "
        <table id=\"noversions\" class=\"data\">
            <thead>
                <tr>
                    <th></th>
                    <th>";
            // line 120
            echo _gettext("Table");
            echo "</th>
                    <th>";
            // line 121
            echo _gettext("Action");
            echo "</th>
                </tr>
            </thead>
            <tbody>
                ";
            // line 125
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["untracked_tables"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["table_name"]) {
                // line 126
                echo "                  ";
                if ((PhpMyAdmin\Tracker::getVersion(($context["db"] ?? null), $context["table_name"]) ==  -1)) {
                    // line 127
                    echo "                    <tr>
                        <td class=\"center\">
                            <input type=\"checkbox\" name=\"selected_tbl[]\"
                                class=\"checkall\" id=\"selected_tbl_";
                    // line 130
                    echo twig_escape_filter($this->env, $context["table_name"], "html", null, true);
                    echo "\"
                                value=\"";
                    // line 131
                    echo twig_escape_filter($this->env, $context["table_name"], "html", null, true);
                    echo "\">
                        </td>
                        <th>
                            <label for=\"selected_tbl_";
                    // line 134
                    echo twig_escape_filter($this->env, $context["table_name"], "html", null, true);
                    echo "\">
                                ";
                    // line 135
                    echo twig_escape_filter($this->env, $context["table_name"], "html", null, true);
                    echo "
                            </label>
                        </th>
                        <td>
                            <a href=\"tbl_tracking.php";
                    // line 139
                    echo ($context["url_query"] ?? null);
                    echo "&amp;table=";
                    echo twig_escape_filter($this->env, $context["table_name"], "html", null, true);
                    echo "\">
                                ";
                    // line 140
                    echo PhpMyAdmin\Util::getIcon("eye", _gettext("Track table"));
                    echo "
                            </a>
                        </td>
                    </tr>
                  ";
                }
                // line 145
                echo "                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['table_name'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 146
            echo "            </tbody>
        </table>
        ";
            // line 148
            $this->loadTemplate("select_all.twig", "database/tracking/tables.twig", 148)->display(twig_to_array(["pma_theme_image" =>             // line 149
($context["pma_theme_image"] ?? null), "text_dir" =>             // line 150
($context["text_dir"] ?? null), "form_name" => "untrackedForm"]));
            // line 153
            echo "        ";
            echo PhpMyAdmin\Util::getButtonOrImage("submit_mult", "mult_submit", _gettext("Track table"), "eye", "track");
            // line 159
            echo "
    </form>
";
        }
    }

    public function getTemplateName()
    {
        return "database/tracking/tables.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  309 => 159,  306 => 153,  304 => 150,  303 => 149,  302 => 148,  298 => 146,  292 => 145,  284 => 140,  278 => 139,  271 => 135,  267 => 134,  261 => 131,  257 => 130,  252 => 127,  249 => 126,  245 => 125,  238 => 121,  234 => 120,  226 => 115,  219 => 112,  217 => 111,  211 => 107,  208 => 101,  206 => 98,  205 => 97,  204 => 96,  200 => 94,  189 => 89,  186 => 88,  184 => 87,  183 => 85,  182 => 82,  181 => 81,  176 => 78,  173 => 77,  171 => 76,  170 => 74,  169 => 71,  168 => 70,  163 => 67,  160 => 66,  158 => 65,  157 => 62,  156 => 61,  149 => 56,  146 => 55,  144 => 53,  143 => 50,  142 => 49,  136 => 45,  130 => 42,  124 => 39,  118 => 36,  111 => 32,  107 => 31,  101 => 28,  97 => 27,  92 => 24,  88 => 23,  81 => 19,  77 => 18,  73 => 17,  69 => 16,  65 => 15,  61 => 14,  57 => 13,  49 => 8,  42 => 4,  39 => 3,  37 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("", "database/tracking/tables.twig", "C:\\Users\\Levathian\\Desktop\\iot-tool2\\iot-tool-automation\\New folder\\backpack-demo\\public\\phpMyAdmin\\templates\\database\\tracking\\tables.twig");
    }
}
