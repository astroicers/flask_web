# -*- coding: utf-8 -*-

from flask import Flask, render_template
from pymongo import MongoClient

app = Flask(__name__)
mon = MongoClient('mongodb://' + 'root' + ':' + 'example' + '@127.0.0.1')


@app.route("/<name>")
def index(name):
    scan_list = {}
    target_list = []
    nse_list = {}
    for x in mon.toybox.ip_list.find():
        if x['ip'] not in target_list:
            target_list.append(x['ip'])
            scan_list.update({x['ip']: {}})
            nse_list.update({x['ip']: {}})

    for x in target_list:
        for y in mon.toybox.ip_list.find({'ip': x}):
            scan_list[x].update(
                {y['port']: y, 'time_man': y['time_man'], 'time_pc': y['time_pc']})
    #############################################
    for x in target_list:
        for y in mon.toybox.nse_list.find({'_id': x}):
            nse_list[x].update(y)

    return render_template('index.html', name=name, nse_list=nse_list, target_list=target_list, scan_list=scan_list)


if __name__ == "__main__":
    app.run(host='127.0.0.1', port=5200, debug=True)
