import urllib.request, json, sys

query = json.dumps({"query": 'query { __schema { types { name fields { name } } } }'}).encode()
req = urllib.request.Request("http://localhost:3002/graphql", data=query, headers={"Content-Type": "application/json"})
res = json.loads(urllib.request.urlopen(req).read())

for t in res.get("data",{}).get("__schema",{}).get("types",[]):
    n = t["name"].lower()
    fn = t.get("fields") or []
    if any(x in n for x in ["theme","auth","login","logo","site","setting","authentication","mutation"]):
        print(f"=== {t['name']} ===")
        for f in fn:
            print(f"  {f['name']}")
        print()
