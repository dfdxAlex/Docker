import requests

url = "http://php-server:83?ok"  # Замените на реальный URL вашего API

response = requests.get(url)

if response.status_code == 200:
    data = response.json()
    print(data)
