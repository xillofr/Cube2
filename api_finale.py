import flask
from flask import request, jsonify
import sqlite3
import mariadb
import sys

app = flask.Flask(__name__)
app.config["DEBUG"] = True


@app.route('/', methods=['GET'])
def home():
    return '''<h1>sonde</h1>
<p>API SONDE</p>'''


@app.route('/api/sonde/donnee/all', methods=['GET'])
def api_all():
    conn = mariadb.connect(
        host = '127.0.0.1',
        user = 'root',
        password = 'root',)
    cursor = conn.cursor()
    stmt = ("SELECT * FROM cube2.entries;")
    result = cursor.execute(stmt)
    result2 = cursor.fetchall()
    cursor.connection.close()
    return jsonify(result2)



@app.errorhandler(404)
def page_not_found(e):
    return "<h1>404</h1><p>The resource could not be found.</p>", 404


@app.route('/api/sonde/donnee', methods=['POST'])
def api_filter():
    query_parameters = request.args

    id_sonde = query_parameters.get('id_sonde')
    temperature = query_parameters.get('temperature')
    humidite = query_parameters.get('humidite')
    time = query_parameters.get('time')

    conn = mariadb.connect(
        host = '127.0.0.1',
        user = 'root',
        password = 'root',
        database="cube2"
	)
    cursor = conn.cursor()
   # cursor.execute("SELECT * FROM entries WHERE temperature=?",(temperature,))
    cursor.execute("INSERT INTO entries VALUES (null,'2022-01-01 08:00:00',1,53,12)")
   # cursor.execute(stmt)
   # results = cursor.fetchall()
   # cursor.connection.close()
  #  results = cursor.execute(query, to_filter).fetchall()
    #return "INSERT INTO entries VALUES (null, '2022-01-01 08:00:00', 1, ?, ?)",("humidite","temperature")
    return "ok"
app.run()
