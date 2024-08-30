
# from django.urls import path,include
# from .views import CarsViewset
# urlpatterns = [
#     path('cars/', CarsViewset.as_view()),
#     path('cars/<int:id>/',CarsViewset.as_view()),
# ]

# cars/urls.py

from django.urls import path
from .views import CarsListView, CarDetailView  # Assuming you have these views

urlpatterns = [
    path('cars/', CarsListView.as_view(), name='cars-list'),
    path('cars/<int:pk>/', CarDetailView.as_view(), name='car-detail'),
]
