# Use the stable .NET 9.0 runtime image for running the app
FROM mcr.microsoft.com/dotnet/aspnet:9.0 AS base
WORKDIR /app
EXPOSE 5000

# Use the stable .NET 9.0 SDK image for building the app
FROM mcr.microsoft.com/dotnet/sdk:9.0 AS build
WORKDIR /src

# Copy the project file and restore dependencies
COPY Todo.Api.csproj ./
RUN dotnet restore "./Todo.Api.csproj"

# Copy the remaining source code and build the project
COPY . .
RUN dotnet publish -c Release -o /app/publish

# Build the final runtime image
FROM base AS final
WORKDIR /app
COPY --from=build /app/publish .
ENTRYPOINT ["dotnet", "Todo.Api.dll"]
