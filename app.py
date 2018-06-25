# -*- coding: utf-8 -*-

from flask import Flask, render_template, request
from pymongo import MongoClient
import re


def fuzzer_search(fuzzer_input):
    fuzzer_ip_list = ['product', 'ip', 'extrainfo',
                      'port',  'name', 'cpe', 'version', 'time_man']
    out_list = []
    for fuzzer_data in fuzzer_ip_list:
        rexExp = re.compile('.*' + fuzzer_input + '.*', re.IGNORECASE)
        res = mon.toybox.ip_list.find({fuzzer_data: rexExp})

        for rs in res:
            if rs not in out_list:
                out_list.append(rs)

    fuzzer_nse_list = ['vuln.ms17-010.hack',
                       'vuln.ms08-067.hack', 'vuln.ms12-020.hack']

    for fuzzer_data in fuzzer_nse_list:
        rexExp = re.compile('.*' + fuzzer_input + '.*', re.IGNORECASE)
        res = mon.toybox.nse_list.find({fuzzer_data: rexExp})

        for rs in res:
            if rs not in out_list:
                out_list.append(rs)

    return out_list


app = Flask(__name__)
mon = MongoClient('mongodb://' + 'root' + ':' + 'example' + '@127.0.0.1')


@app.route("/", methods=['GET', 'POST'])
def index():
    scan_list = {}
    target_list = []
    nse_list = {}
    search_filter = ''
    if request.method == 'POST':
        search_filter = request.form['search_filter']
    # ip form
    for x in fuzzer_search(search_filter):
        if x['ip'] not in target_list:
            target_list.append(x['ip'])
            scan_list.update({x['ip']: {}})
            nse_list.update({x['ip']: {}})
    # port form
    for x in target_list:
        for y in mon.toybox.ip_list.find({'ip': x}):
            scan_list[x].update(
                {y['port']: y, 'time_man': y['time_man'], 'time_pc': y['time_pc']})
    # nse form
    for x in target_list:
        for y in mon.toybox.nse_list.find({'_id': x}):
            nse_list[x].update(y)

    return render_template('index.html', nse_list=nse_list, target_list=target_list, scan_list=scan_list, search_filter=search_filter)


if __name__ == "__main__":
    app.run(host='127.0.0.1', port=5200, debug=True)
