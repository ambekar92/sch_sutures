var margin = {
    top: 50,
    right: 120,
    bottom:0,
    left: 200
},
width = 960 - margin.right - margin.left,
height = 800 - margin.top - margin.bottom;


var root = {
    "name": "Healthium",
        "children": [{
        "name": "Dashboard",
            "children": [{
            "name": "Overview",
            //     "children": [{
            //     "name": "AgglomerativeCluster",
            //         "size": 3938
            // }, {
            //     "name": "CommunityStructure",
            //         "size": 3812
            // }, {
            //     "name": "HierarchicalCluster",
            //         "size": 6714
            // }, {
            //     "name": "MergeEdge",
            //         "size": 743
            // }]
        }, {
            "name": "Jobcard Analytics",
            //     "children": [{
            //     "name": "BetweennessCentrality",
            //         "size": 3534
            // }, {
            //     "name": "LinkDistance",
            //         "size": 5731
            // }, {
            //     "name": "MaxFlowMinCut",
            //         "size": 7840
            // }, {
            //     "name": "ShortestPaths",
            //         "size": 5914
            // }, {
            //     "name": "SpanningTree",
            //         "size": 3416
            // }]
        }, {
            "name": "Jobcard",
        }]
    }, {
        "name": "Reports",
            "children": [{
            "name": "Department",
        }, {
            "name": "Machine Jobcard",
        }, {
            "name": "Ageing Report",
        }, {
            "name": "Jobcard Status",
        }, {
            "name": "Operator",
        }, {
            "name": "Operator Efficiency",
        },
        {
            "name": "Department Monthly",
        }]
    }, {
        "name": "Rejection Analysis",
            "children": [{
            "name": "Yearly Rejection",
        }, {
            "name": "Monthly Rejection",
        }, {
            "name": "Jobcard Rejection",
        }, {
            "name": "Reject Reasons",
        }]
    }, {
        "name": "Production",
            "children": [{
            "name": "Dashboard",
        }, {
            "name": "Data Sheet",
        }, {
            "name": "Production Status",
        }, {
            "name": "Reason Report",
        }]
    }, {
        "name": "Consumables Analysis",
            "children": [{
            "name": "Department Analysis",
        },{
            "name": "Reasons Analysis",
        }]
    }, {
        "name": "Checklists Approval",
            "children": [{
            "name": "Checklists",
        }]
    }, {
        "name": "Employee",
            "children": [{
            "name": "Employee List",
        }, {
            "name": "Employee QR code",
        }]
    }, {
        "name": "Label Printing",
            "children": [{
            "name": "Printing",
        }]
    }, {
        "name": "OEE",
            "children": [{
            "name": "Dashboard",
        }, {
            "name": "History",
        }]
    }, {
        "name": "SCH Support Desk",
            "children": [{
            "name": "Support Desk",
        }]
    }]
};

var i = 0,
    duration = 750,
    rectW = 105,
    rectH = 30;

var tree = d3.layout.tree().nodeSize([120, 40]);
var diagonal = d3.svg.diagonal()
    .projection(function (d) {
    return [d.x + rectW / 2, d.y + rectH / 2];
});

var svg = d3.select("#body").append("svg").attr("width", 1000).attr("height", 1000)
    .call(zm = d3.behavior.zoom().scaleExtent([-3,3]).on("zoom", redraw)).append("g")
    .attr("transform", "translate(" + 750 + "," + 20 + ")");

//necessary so that zoom knows where to zoom and unzoom from
zm.translate([750, 20]);

root.x0 = 0;
root.y0 = height / 2;

function collapse(d) {
    if (d.children) {
        d._children = d.children;
        d._children.forEach(collapse);
        d.children = null;
    }
}

root.children.forEach(collapse);
update(root);

d3.select("#body").style("height", "800px");

function update(source) {

    // Compute the new tree layout.
    var nodes = tree.nodes(root).reverse(),
        links = tree.links(nodes);

    // Normalize for fixed-depth.
    nodes.forEach(function (d) {
        d.y = d.depth * 180;
    });

    // Update the nodes…
    var node = svg.selectAll("g.node")
        .data(nodes, function (d) {
        return d.id || (d.id = ++i);
    });

    // Enter any new nodes at the parent's previous position.
    var nodeEnter = node.enter().append("g")
        .attr("class", "node")
        .attr("transform", function (d) {
        return "translate(" + source.x0 + "," + source.y0 + ")";
    })
        .on("click", click);

    nodeEnter.append("rect")
        .attr("width", rectW)
        .attr("height", rectH)
        .attr("stroke", "black")
        .attr("stroke-width", 1)
        .style("fill", function (d) {
        return d._children ? "lightsteelblue" : "#fff";
    });

    nodeEnter.append("text")
        .attr("x", rectW / 2)
        .attr("y", rectH / 2)
        .attr("dy", ".35em")
        .attr("text-anchor", "middle")
        .text(function (d) {
        return d.name;
    });

    // Transition nodes to their new position.
    var nodeUpdate = node.transition()
        .duration(duration)
        .attr("transform", function (d) {
        return "translate(" + d.x + "," + d.y + ")";
    });

    nodeUpdate.select("rect")
        .attr("width", rectW)
        .attr("height", rectH)
        .attr("stroke", "black")
        .attr("stroke-width", 1)
        .style("fill", function (d) {
        return d._children ? "lightsteelblue" : "#fff";
    });

    nodeUpdate.select("text")
        .style("fill-opacity", 1);

    // Transition exiting nodes to the parent's new position.
    var nodeExit = node.exit().transition()
        .duration(duration)
        .attr("transform", function (d) {
        return "translate(" + source.x + "," + source.y + ")";
    })
        .remove();

    nodeExit.select("rect")
        .attr("width", rectW)
        .attr("height", rectH)
    //.attr("width", bbox.getBBox().width)""
    //.attr("height", bbox.getBBox().height)
    .attr("stroke", "black")
        .attr("stroke-width", 1);

    nodeExit.select("text");

    // Update the links…
    var link = svg.selectAll("path.link")
        .data(links, function (d) {
        return d.target.id;
    });

    // Enter any new links at the parent's previous position.
    link.enter().insert("path", "g")
        .attr("class", "link")
        .attr("x", rectW / 2)
        .attr("y", rectH / 2)
        .attr("d", function (d) {
        var o = {
            x: source.x0,
            y: source.y0
        };
        return diagonal({
            source: o,
            target: o
        });
    });

    // Transition links to their new position.
    link.transition()
        .duration(duration)
        .attr("d", diagonal);

    // Transition exiting nodes to the parent's new position.
    link.exit().transition()
        .duration(duration)
        .attr("d", function (d) {
        var o = {
            x: source.x,
            y: source.y
        };
        return diagonal({
            source: o,
            target: o
        });
    })
        .remove();

    // Stash the old positions for transition.
    nodes.forEach(function (d) {
        d.x0 = d.x;
        d.y0 = d.y;
    });
}

// Toggle children on click.
function click(d) {
    if (d.children) {
        d._children = d.children;
        d.children = null;
    } else {
        d.children = d._children;
        d._children = null;
    }
    update(d);
}

//Redraw for zoom
function redraw() {
  //console.log("here", d3.event.translate, d3.event.scale);
  svg.attr("transform",
      "translate(" + d3.event.translate + ")"
      + " scale(" + d3.event.scale + ")");
}