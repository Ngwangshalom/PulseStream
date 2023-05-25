from flask import Flask, jsonify

import psycopg2

# // company: PulseStream
# // Developed by: Ngwang Shalom
# // Location: Cameroon/Bamenda
# // Languages: php/hack/javascript/node(library)
# // position: Senior dev
# //
# //
# // Please add your own description if you are a contributor
# //
# //
# //
app = Flask(__name__)

# Establish a database connection
def get_db_connection():
    connection = psycopg2.connect(
        host="your_database_host",
        database="your_database_name",
        user="your_username",
        password="your_password"
    )
    return connection

# Retrieve user information from the database
@app.route('/users', methods=['GET'])
def get_users():
    connection = get_db_connection()
    cursor = connection.cursor()
    cursor.execute("SELECT name, age FROM users")
    users = cursor.fetchall()
    cursor.close()
    connection.close()

    # Format the data as a list of dictionaries
    user_data = [{'name': user[0], 'age': user[1]} for user in users]
    return jsonify(user_data)

# Retrieve general information from the database
@app.route('/general-info', methods=['GET'])
def get_general_info():
    connection = get_db_connection()
    cursor = connection.cursor()
    cursor.execute("SELECT app_name, version FROM app_info")
    info = cursor.fetchone()
    cursor.close()
    connection.close()

    # Format the data as a dictionary
    general_info = {'app_name': info[0], 'version': info[1]}
    return jsonify(general_info)

# Retrieve statistics from the database
@app.route('/statistics', methods=['GET'])
def get_statistics():
    connection = get_db_connection()
    cursor = connection.cursor()
    cursor.execute("SELECT likes, comments FROM statistics")
    stats = cursor.fetchone()
    cursor.close()
    connection.close()

    # Format the data as a dictionary
    statistics = {'likes': stats[0], 'comments': stats[1]}
    return jsonify(statistics)

# Retrieve worries from the database
@app.route('/worries', methods=['GET'])
def get_worries():
    connection = get_db_connection()
    cursor = connection.cursor()
    cursor.execute("SELECT message FROM worries")
    worries = cursor.fetchall()
    cursor.close()
    connection.close()

    # Format the data as a list of dictionaries
    worry_data = [{'message': worry[0]} for worry in worries]
    return jsonify(worry_data)

# Retrieve event handling from the database
@app.route('/event-handling', methods=['GET'])
def get_event_handling():
    connection = get_db_connection()
    cursor = connection.cursor()
    cursor.execute("SELECT event FROM event_handling")
    event = cursor.fetchone()
    cursor.close()
    connection.close()

    # Format the data as a dictionary
    event_handling = {'event': event[0]}
    return jsonify(event_handling)

# Retrieve subscriptions from the database
@app.route('/subscriptions', methods=['GET'])
def get_subscriptions():
    connection = get_db_connection()
    cursor = connection.cursor()
    cursor.execute("SELECT name FROM subscriptions")
    subscriptions = cursor.fetchall()
    cursor.close()
    connection.close()

    # Format the data as a list of dictionaries
    subscription_data = [{'name': sub[0]} for sub in subscriptions]
    return jsonify(subscription_data)

if __name__ == '__main__':
    app.run(debug=True)
