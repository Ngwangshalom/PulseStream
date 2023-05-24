import requests

# Retrieve user information
response = requests.get('http://127.0.0.1:5000/users')
if response.status_code == 200:
    users = response.json()
    print("User Information:")
    for user in users:
        print(f"Name: {user['name']}, Age: {user['age']}")

# Retrieve statistics
response = requests.get('http://127.0.0.1:5000/statistics')
if response.status_code == 200:
    statistics = response.json()
    print("\nStatistics:")
    print(f"Likes: {statistics['likes']}")
    print(f"Comments: {statistics['comments']}")

# Retrieve notifications
response = requests.get('http://127.0.0.1:5000/notifications')
if response.status_code == 200:
    notifications = response.json()
    print("\nNotifications:")
    for notification in notifications:
        print(f"Notification: {notification['message']}")

# Retrieve worries
response = requests.get('http://127.0.0.1:5000/worries')
if response.status_code == 200:
    worries = response.json()
    print("\nWorries:")
    for worry in worries:
        print(f"Worry: {worry['message']}")

# Retrieve event handling
response = requests.get('http://127.0.0.1:5000/event-handling')
if response.status_code == 200:
    event_handling = response.json()
    print("\nEvent Handling:")
    print(f"Event: {event_handling['event']}")

# Retrieve subscriptions
response = requests.get('http://127.0.0.1:5000/subscriptions')
if response.status_code == 200:
    subscriptions = response.json()
    print("\nSubscriptions:")
    for subscription in subscriptions:
        print(f"Subscription: {subscription['name']}")

# Retrieve general information
response = requests.get('http://127.0.0.1:5000/general-info')
if response.status_code == 200:
    info = response.json()
    print("\nGeneral Information:")
    print(f"App Name: {info['app_name']}")
    print(f"Version: {info['version']}")
