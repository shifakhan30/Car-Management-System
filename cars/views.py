

from rest_framework import status
from rest_framework.response import Response
from rest_framework.views import APIView
from .models import Cars
from .serializers import CarsSerializer
from django.http import Http404
class CarsListView(APIView):
    def get(self, request):
        cars = Cars.objects.all()
        serializer = CarsSerializer(cars, many=True)
        return Response({"status": "success", "data": serializer.data}, status=status.HTTP_200_OK)

    def post(self, request):
        serializer = CarsSerializer(data=request.data)
        if serializer.is_valid():
            serializer.save()
            return Response({"status": "success", "data": serializer.data}, status=status.HTTP_200_OK)
        else:
            return Response({"status": "error", "data": serializer.errors}, status=status.HTTP_400_BAD_REQUEST)

class CarDetailView(APIView):
    def get_object(self, pk):
        try:
            return Cars.objects.get(pk=pk)
        except Cars.DoesNotExist:
            raise Http404

    def get(self, request, pk):
        car = self.get_object(pk)
        serializer = CarsSerializer(car)
        return Response({"status": "success", "data": serializer.data}, status=status.HTTP_200_OK)

    def put(self, request, pk):
        car = self.get_object(pk)
        serializer = CarsSerializer(car, data=request.data)
        if serializer.is_valid():
            serializer.save()
            return Response({"status": "success", "data": serializer.data}, status=status.HTTP_200_OK)
        else:
            return Response({"status": "error", "data": serializer.errors}, status=status.HTTP_400_BAD_REQUEST)

    def delete(self, request, pk):
        car = self.get_object(pk)
        car.delete()
        return Response({"status": "success", "data": "Car deleted successfully"}, status=status.HTTP_204_NO_CONTENT)
