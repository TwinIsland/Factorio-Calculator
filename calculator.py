import json
import pprint

data = dict(json.load(open("data.json", 'rb')))


def get_ing(item):
    steps = []
    helper(item, steps)
    return steps


def helper(item, steps):
    if not len(data[item]):
        return
    ingredient = data[item][0]['ingredients']
    steps.append(ingredient)
    for i in ingredient:
        return helper(i['name'], steps)


pprint.pprint(get_ing('speed-module'))


# [[{'amount': 5, 'name': 'advanced-circuit', 'type': 'item'},
#   {'amount': 5, 'name': 'electronic-circuit', 'type': 'item'}],
#  [{'amount': 2, 'name': 'electronic-circuit', 'type': 'item'},
#   {'amount': 2, 'name': 'plastic-bar', 'type': 'item'},
#   {'amount': 4, 'name': 'copper-cable', 'type': 'item'}],
#  [{'amount': 1, 'name': 'iron-plate', 'type': 'item'},
#   {'amount': 3, 'name': 'copper-cable', 'type': 'item'}],
#  [{'amount': 1, 'name': 'iron-ore', 'type': 'item'}]]
