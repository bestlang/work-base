<template>
	<div>
		<!--<div v-title="'组织架构图'"></div>-->
		<!--组织架构图-->
		<!--<div>-->
			<!--<button @click="collapse">折叠</button>-->
			<!--<button @click="expand">打开</button>-->
			<!--<js-mind id="js-mind-123" :values="mind" :options="options" ref="jsMind" height="1000px"></js-mind>-->
		<!--</div>-->
		<v-chart :options="options" style="width: 100%;height: 100vh"/>
	</div>
</template>
<script>
    import Vue from 'vue'
    // import jm from 'vue-jsmind'
    // Vue.use(jm)
    import ECharts from 'vue-echarts' // refers to components/ECharts.vue in webpack

    // import ECharts modules manually to reduce bundle size
    import 'echarts/lib/chart/line'
    import 'echarts/lib/chart/bar'
    import 'echarts/lib/chart/tree'
    import 'echarts/lib/component/tooltip'
    import 'echarts/lib/component/title'
    import 'echarts/lib/component/polar'
    import 'echarts/lib/component/angleAxis'
    import 'echarts/lib/component/legend'

    Vue.component('v-chart', ECharts)

	export default {
        name: 'sniperEmployeeGraph',
		data(){
		    return {
		        options: {
                    tooltip: {
                        trigger: 'item',
                        triggerOn: 'mousemove'
                    },
                    series: [
                        {
                            type: 'tree',
                            data: [{
                                "name": "flare",
                                "children": [
                                    {
                                        "name": "analytics",
                                        "children": [
                                            {
                                                "name": "cluster",
                                                "children": [
                                                    {"name": "AgglomerativeCluster", "value": 3938},
                                                    {"name": "CommunityStructure", "value": 3812},
                                                    {"name": "HierarchicalCluster", "value": 6714},
                                                    {"name": "MergeEdge", "value": 743}
                                                ]
                                            },
                                            {
                                                "name": "graph",
                                                "children": [
                                                    {"name": "BetweennessCentrality", "value": 3534},
                                                    {"name": "LinkDistance", "value": 5731},
                                                    {"name": "MaxFlowMinCut", "value": 7840},
                                                    {"name": "ShortestPaths", "value": 5914},
                                                    {"name": "SpanningTree", "value": 3416}
                                                ]
                                            },
                                            {
                                                "name": "optimization",
                                                "children": [
                                                    {"name": "AspectRatioBanker", "value": 7074}
                                                ]
                                            }
                                        ]
                                    },
                                    {
                                        "name": "animate",
                                        "children": [
                                            {"name": "Easing", "value": 17010},
                                            {"name": "FunctionSequence", "value": 5842},
                                            {
                                                "name": "interpolate",
                                                "children": [
                                                    {"name": "ArrayInterpolator", "value": 1983},
                                                    {"name": "ColorInterpolator", "value": 2047},
                                                    {"name": "DateInterpolator", "value": 1375},
                                                    {"name": "Interpolator", "value": 8746},
                                                    {"name": "MatrixInterpolator", "value": 2202},
                                                    {"name": "NumberInterpolator", "value": 1382},
                                                    {"name": "ObjectInterpolator", "value": 1629},
                                                    {"name": "PointInterpolator", "value": 1675},
                                                    {"name": "RectangleInterpolator", "value": 2042}
                                                ]
                                            },
                                            {"name": "ISchedulable", "value": 1041},
                                            {"name": "Parallel", "value": 5176},
                                            {"name": "Pause", "value": 449},
                                            {"name": "Scheduler", "value": 5593},
                                            {"name": "Sequence", "value": 5534},
                                            {"name": "Transition", "value": 9201},
                                            {"name": "Transitioner", "value": 19975},
                                            {"name": "TransitionEvent", "value": 1116},
                                            {"name": "Tween", "value": 6006}
                                        ]
                                    },
                                    {
                                        "name": "data",
                                        "children": [
                                            {
                                                "name": "converters",
                                                "children": [
                                                    {"name": "Converters", "value": 721},
                                                    {"name": "DelimitedTextConverter", "value": 4294},
                                                    {"name": "GraphMLConverter", "value": 9800},
                                                    {"name": "IDataConverter", "value": 1314},
                                                    {"name": "JSONConverter", "value": 2220}
                                                ]
                                            },
                                            {"name": "DataField", "value": 1759},
                                            {"name": "DataSchema", "value": 2165},
                                            {"name": "DataSet", "value": 586},
                                            {"name": "DataSource", "value": 3331},
                                            {"name": "DataTable", "value": 772},
                                            {"name": "DataUtil", "value": 3322}
                                        ]
                                    },
                                    {
                                        "name": "display",
                                        "children": [
                                            {"name": "DirtySprite", "value": 8833},
                                            {"name": "LineSprite", "value": 1732},
                                            {"name": "RectSprite", "value": 3623},
                                            {"name": "TextSprite", "value": 10066}
                                        ]
                                    },
                                    {
                                        "name": "flex",
                                        "children": [
                                            {"name": "FlareVis", "value": 4116}
                                        ]
                                    },
                                    {
                                        "name": "physics",
                                        "children": [
                                            {"name": "DragForce", "value": 1082},
                                            {"name": "GravityForce", "value": 1336},
                                            {"name": "IForce", "value": 319},
                                            {"name": "NBodyForce", "value": 10498},
                                            {"name": "Particle", "value": 2822},
                                            {"name": "Simulation", "value": 9983},
                                            {"name": "Spring", "value": 2213},
                                            {"name": "SpringForce", "value": 1681}
                                        ]
                                    },
                                    {
                                        "name": "query",
                                        "children": [
                                            {"name": "AggregateExpression", "value": 1616},
                                            {"name": "And", "value": 1027},
                                            {"name": "Arithmetic", "value": 3891},
                                            {"name": "Average", "value": 891},
                                            {"name": "BinaryExpression", "value": 2893},
                                            {"name": "Comparison", "value": 5103},
                                            {"name": "CompositeExpression", "value": 3677},
                                            {"name": "Count", "value": 781},
                                            {"name": "DateUtil", "value": 4141},
                                            {"name": "Distinct", "value": 933},
                                            {"name": "Expression", "value": 5130},
                                            {"name": "ExpressionIterator", "value": 3617},
                                            {"name": "Fn", "value": 3240},
                                            {"name": "If", "value": 2732},
                                            {"name": "IsA", "value": 2039},
                                            {"name": "Literal", "value": 1214},
                                            {"name": "Match", "value": 3748},
                                            {"name": "Maximum", "value": 843},
                                            {
                                                "name": "methods",
                                                "children": [
                                                    {"name": "add", "value": 593},
                                                    {"name": "and", "value": 330},
                                                    {"name": "average", "value": 287},
                                                    {"name": "count", "value": 277},
                                                    {"name": "distinct", "value": 292},
                                                    {"name": "div", "value": 595},
                                                    {"name": "eq", "value": 594},
                                                    {"name": "fn", "value": 460},
                                                    {"name": "gt", "value": 603},
                                                    {"name": "gte", "value": 625},
                                                    {"name": "iff", "value": 748},
                                                    {"name": "isa", "value": 461},
                                                    {"name": "lt", "value": 597},
                                                    {"name": "lte", "value": 619},
                                                    {"name": "max", "value": 283},
                                                    {"name": "min", "value": 283},
                                                    {"name": "mod", "value": 591},
                                                    {"name": "mul", "value": 603},
                                                    {"name": "neq", "value": 599},
                                                    {"name": "not", "value": 386},
                                                    {"name": "or", "value": 323},
                                                    {"name": "orderby", "value": 307},
                                                    {"name": "range", "value": 772},
                                                    {"name": "select", "value": 296},
                                                    {"name": "stddev", "value": 363},
                                                    {"name": "sub", "value": 600},
                                                    {"name": "sum", "value": 280},
                                                    {"name": "update", "value": 307},
                                                    {"name": "variance", "value": 335},
                                                    {"name": "where", "value": 299},
                                                    {"name": "xor", "value": 354},
                                                    {"name": "-", "value": 264}
                                                ]
                                            },
                                            {"name": "Minimum", "value": 843},
                                            {"name": "Not", "value": 1554},
                                            {"name": "Or", "value": 970},
                                            {"name": "Query", "value": 13896},
                                            {"name": "Range", "value": 1594},
                                            {"name": "StringUtil", "value": 4130},
                                            {"name": "Sum", "value": 791},
                                            {"name": "Variable", "value": 1124},
                                            {"name": "Variance", "value": 1876},
                                            {"name": "Xor", "value": 1101}
                                        ]
                                    },
                                    {
                                        "name": "scale",
                                        "children": [
                                            {"name": "IScaleMap", "value": 2105},
                                            {"name": "LinearScale", "value": 1316},
                                            {"name": "LogScale", "value": 3151},
                                            {"name": "OrdinalScale", "value": 3770},
                                            {"name": "QuantileScale", "value": 2435},
                                            {"name": "QuantitativeScale", "value": 4839},
                                            {"name": "RootScale", "value": 1756},
                                            {"name": "Scale", "value": 4268},
                                            {"name": "ScaleType", "value": 1821},
                                            {"name": "TimeScale", "value": 5833}
                                        ]
                                    },
                                    {
                                        "name": "util",
                                        "children": [
                                            {"name": "Arrays", "value": 8258},
                                            {"name": "Colors", "value": 10001},
                                            {"name": "Dates", "value": 8217},
                                            {"name": "Displays", "value": 12555},
                                            {"name": "Filter", "value": 2324},
                                            {"name": "Geometry", "value": 10993},
                                            {
                                                "name": "heap",
                                                "children": [
                                                    {"name": "FibonacciHeap", "value": 9354},
                                                    {"name": "HeapNode", "value": 1233}
                                                ]
                                            },
                                            {"name": "IEvaluable", "value": 335},
                                            {"name": "IPredicate", "value": 383},
                                            {"name": "IValueProxy", "value": 874},
                                            {
                                                "name": "math",
                                                "children": [
                                                    {"name": "DenseMatrix", "value": 3165},
                                                    {"name": "IMatrix", "value": 2815},
                                                    {"name": "SparseMatrix", "value": 3366}
                                                ]
                                            },
                                            {"name": "Maths", "value": 17705},
                                            {"name": "Orientation", "value": 1486},
                                            {
                                                "name": "palette",
                                                "children": [
                                                    {"name": "ColorPalette", "value": 6367},
                                                    {"name": "Palette", "value": 1229},
                                                    {"name": "ShapePalette", "value": 2059},
                                                    {"name": "SizePalette", "value": 2291}
                                                ]
                                            },
                                            {"name": "Property", "value": 5559},
                                            {"name": "Shapes", "value": 19118},
                                            {"name": "Sort", "value": 6887},
                                            {"name": "Stats", "value": 6557},
                                            {"name": "Strings", "value": 22026}
                                        ]
                                    },
                                    {
                                        "name": "vis",
                                        "children": [
                                            {
                                                "name": "axis",
                                                "children": [
                                                    {"name": "Axes", "value": 1302},
                                                    {"name": "Axis", "value": 24593},
                                                    {"name": "AxisGridLine", "value": 652},
                                                    {"name": "AxisLabel", "value": 636},
                                                    {"name": "CartesianAxes", "value": 6703}
                                                ]
                                            },
                                            {
                                                "name": "controls",
                                                "children": [
                                                    {"name": "AnchorControl", "value": 2138},
                                                    {"name": "ClickControl", "value": 3824},
                                                    {"name": "Control", "value": 1353},
                                                    {"name": "ControlList", "value": 4665},
                                                    {"name": "DragControl", "value": 2649},
                                                    {"name": "ExpandControl", "value": 2832},
                                                    {"name": "HoverControl", "value": 4896},
                                                    {"name": "IControl", "value": 763},
                                                    {"name": "PanZoomControl", "value": 5222},
                                                    {"name": "SelectionControl", "value": 7862},
                                                    {"name": "TooltipControl", "value": 8435}
                                                ]
                                            },
                                            {
                                                "name": "data",
                                                "children": [
                                                    {"name": "Data", "value": 20544},
                                                    {"name": "DataList", "value": 19788},
                                                    {"name": "DataSprite", "value": 10349},
                                                    {"name": "EdgeSprite", "value": 3301},
                                                    {"name": "NodeSprite", "value": 19382},
                                                    {
                                                        "name": "render",
                                                        "children": [
                                                            {"name": "ArrowType", "value": 698},
                                                            {"name": "EdgeRenderer", "value": 5569},
                                                            {"name": "IRenderer", "value": 353},
                                                            {"name": "ShapeRenderer", "value": 2247}
                                                        ]
                                                    },
                                                    {"name": "ScaleBinding", "value": 11275},
                                                    {"name": "Tree", "value": 7147},
                                                    {"name": "TreeBuilder", "value": 9930}
                                                ]
                                            },
                                            {
                                                "name": "events",
                                                "children": [
                                                    {"name": "DataEvent", "value": 2313},
                                                    {"name": "SelectionEvent", "value": 1880},
                                                    {"name": "TooltipEvent", "value": 1701},
                                                    {"name": "VisualizationEvent", "value": 1117}
                                                ]
                                            },
                                            {
                                                "name": "legend",
                                                "children": [
                                                    {"name": "Legend", "value": 20859},
                                                    {"name": "LegendItem", "value": 4614},
                                                    {"name": "LegendRange", "value": 10530}
                                                ]
                                            },
                                            {
                                                "name": "operator",
                                                "children": [
                                                    {
                                                        "name": "distortion",
                                                        "children": [
                                                            {"name": "BifocalDistortion", "value": 4461},
                                                            {"name": "Distortion", "value": 6314},
                                                            {"name": "FisheyeDistortion", "value": 3444}
                                                        ]
                                                    },
                                                    {
                                                        "name": "encoder",
                                                        "children": [
                                                            {"name": "ColorEncoder", "value": 3179},
                                                            {"name": "Encoder", "value": 4060},
                                                            {"name": "PropertyEncoder", "value": 4138},
                                                            {"name": "ShapeEncoder", "value": 1690},
                                                            {"name": "SizeEncoder", "value": 1830}
                                                        ]
                                                    },
                                                    {
                                                        "name": "filter",
                                                        "children": [
                                                            {"name": "FisheyeTreeFilter", "value": 5219},
                                                            {"name": "GraphDistanceFilter", "value": 3165},
                                                            {"name": "VisibilityFilter", "value": 3509}
                                                        ]
                                                    },
                                                    {"name": "IOperator", "value": 1286},
                                                    {
                                                        "name": "label",
                                                        "children": [
                                                            {"name": "Labeler", "value": 9956},
                                                            {"name": "RadialLabeler", "value": 3899},
                                                            {"name": "StackedAreaLabeler", "value": 3202}
                                                        ]
                                                    },
                                                    {
                                                        "name": "layout",
                                                        "children": [
                                                            {"name": "AxisLayout", "value": 6725},
                                                            {"name": "BundledEdgeRouter", "value": 3727},
                                                            {"name": "CircleLayout", "value": 9317},
                                                            {"name": "CirclePackingLayout", "value": 12003},
                                                            {"name": "DendrogramLayout", "value": 4853},
                                                            {"name": "ForceDirectedLayout", "value": 8411},
                                                            {"name": "IcicleTreeLayout", "value": 4864},
                                                            {"name": "IndentedTreeLayout", "value": 3174},
                                                            {"name": "Layout", "value": 7881},
                                                            {"name": "NodeLinkTreeLayout", "value": 12870},
                                                            {"name": "PieLayout", "value": 2728},
                                                            {"name": "RadialTreeLayout", "value": 12348},
                                                            {"name": "RandomLayout", "value": 870},
                                                            {"name": "StackedAreaLayout", "value": 9121},
                                                            {"name": "TreeMapLayout", "value": 9191}
                                                        ]
                                                    },
                                                    {"name": "Operator", "value": 2490},
                                                    {"name": "OperatorList", "value": 5248},
                                                    {"name": "OperatorSequence", "value": 4190},
                                                    {"name": "OperatorSwitch", "value": 2581},
                                                    {"name": "SortOperator", "value": 2023}
                                                ]
                                            },
                                            {"name": "Visualization", "value": 16540}
                                        ]
                                    }
                                ]
                            }
                            ],
                            top: '1%',
                            left: '7%',
                            bottom: '1%',
                            right: '20%',

                            symbolSize: 7,

                            label: {
                                position: 'left',
                                verticalAlign: 'middle',
                                align: 'right',
                                fontSize: 9
                            },

                            leaves: {
                                label: {
                                    position: 'right',
                                    verticalAlign: 'middle',
                                    align: 'left'
                                }
                            },

                            expandAndCollapse: true,
                            animationDuration: 550,
                            animationDurationUpdate: 750
                        }
                    ]
                }
                // mind: {
                //     "meta":{
                //         "name":"jsMind remote",
                //         "author":"hizzgdev@163.com",
                //         "version":"0.2"
                //     },
                //     "format":"node_tree",
                //     "data":{"id":"root","topic":"思纳福","children":[
                //             {"id":"easy","topic":"产品研发事业部","direction":"right","children":[
                //                     {"id":"easy1","topic":"电子学开发组", "children": [
                //                             {"id": "easy11", "topic": "谭玉坤"},
                //                             {"id": "easy12", "topic": "华震"},
                //                             {"id": "easy13", "topic": "孙代玉"},
                //                             {"id": "easy14", "topic": "丁逸"},
                //                             {"id": "easy15", "topic": "李春雷"},
                //                         ]},
                //                     {"id":"easy2","topic":"软件开发组"},
                //                     {"id":"easy3","topic":"测试组"},
                //                     {"id":"easy4","topic":"加工组"},
                //                     {"id":"easy5","topic":"机械设计组"},
                //                     {"id":"easy6","topic":"中试组"},
                //                 ]},
                //             {"id":"open","topic":"总经办","direction":"right","children":[
                //                     {"id":"open1","topic":"盛广济"},
                //                     {"id":"open2","topic":"孙筱"}
                //                 ]},
                //             {"id":"powerful","topic":"财务部","direction":"right","children":[
                //                     {"id":"powerful1","topic":"乔丽丽"},
                //                 ]},
                //             {"id":"other","topic":"人事行政部","direction":"right","children":[
                //                     {"id":"other1","topic":"缪小雨"},
                //                     {"id":"other2","topic":"李梅"}
                //                 ]}
                //         ]}
                // },
                // options: {
                //     container : 'js-mind-123',         // [必选] 容器的ID
                //     editable : true,       // 是否启用编辑
                //     theme : 'primary',           // 主题
                //     mode :'side',           // 显示模式
                //     support_html : true,    // 是否支持节点里的HTML元素
                //     view:{
                //         engine: 'canvas',   // 思维导图各节点之间线条的绘制引擎
                //         hmargin:100,        // 思维导图距容器外框的最小水平距离
                //         vmargin:50,         // 思维导图距容器外框的最小垂直距离
                //         line_width:2,       // 思维导图线条的粗细
                //         line_color:'#555'   // 思维导图线条的颜色
                //     },
                //     layout:{
                //         hspace:30,          // 节点之间的水平间距
                //         vspace:20,          // 节点之间的垂直间距
                //         pspace:13           // 节点与连接线之间的水平间距（用于容纳节点收缩/展开控制器）
                //     },
                //     shortcut:{
                //         enable:true,        // 是否启用快捷键
                //         handles:{},         // 命名的快捷键事件处理器
                //         mapping:{           // 快捷键映射
                //             addchild   : 45,    // <Insert>
                //             addbrother : 13,    // <Enter>
                //             editnode   : 113,   // <F2>
                //             delnode    : 46,    // <Delete>
                //             toggle     : 32,    // <Space>
                //             left       : 37,    // <Left>
                //             up         : 38,    // <Up>
                //             right      : 39,    // <Right>
                //             down       : 40,    // <Down>
                //         }
                //     },
                // }
			}
		},
        methods:{
            collapse(){
                let jm = window.jsMind.current
                jm.collapse_node('easy')
            },
            expand(){
                let jm = window.jsMind.current
                jm.expand_node('easy')
            }
        },
	}
</script>
<style lang="less" scoped>
	#js-mind-123 /deep/ #jsmind_container{
		display: none;
	}
</style>