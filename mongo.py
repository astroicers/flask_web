from pymongo import MongoClient

mon = MongoClient('mongodb://' + 'root' + ':' + 'example' + '@127.0.0.1')

nse_list = {}
scan_list = {}
target_list = []
for x in mon.toybox.ip_list.find():
    if x['ip'] not in target_list:
        target_list.append(x['ip'])
        scan_list.update({x['ip']:{}})
        nse_list.update({x['ip']: {}})
#print target_list
#print
#print scan_list
for x in target_list:
    for y in mon.toybox.ip_list.find({'ip':x}):  
        scan_list[x].update({y['port']:y,'time_man':y['time_man'],'time_pc':y['time_pc']})

#print scan_list
#print
#print scan_list['127.0.0.1']['8081']['name']

for x in target_list:
        for y in mon.toybox.nse_list.find({'_id': x}):
            nse_list[x].update(y)
print nse_list