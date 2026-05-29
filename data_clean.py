import pandas as pd

if __name__ == "__main__":
    original_csv = pd.read_csv("./original_data.csv")

    # Remove Spaces in column names for standardization.
    original_csv = original_csv.rename(
        columns={
            "Series or Movie": "MediaType",
            "Hidden Gem Score": "HiddenGemScore",
            "Country Availability": "CountryAvailability",
            "Runtime": "RuntimeCategory",
            "View Rating": "ViewRating",
            "IMDb Score": "IMBdScore",
            "Rotten Tomatoes Score": "RottenTomatoesScore",
            "Metacritic Score": "MetacriticScore",
            "Awards Nominated": "AwardsNominated",
            "Awards Received": "AwardsReceived",
            "Release Date": "ReleaseDate",
            "Netflix Release Date": "NetflixReleaseDate",
            "Netflix Link": "NetflixLink",
            "IMDb Link": "IMDbLink",
            "IMDb Votes": "IMDbVotes",
            "TMDb Trailer": "TMDbTrailer",
            "Trailer Site": "TrailerSite",
            "Production House": "ProductionHouse",
        }
    )

    original_csv["MinMinutes"] = 0
    original_csv["MaxMinutes"] = 0

    for idx, row in original_csv.iterrows():
        # Title stays the same.

        # Parsable comma-delimited entries are seperated and made into a list.
        for parsable_entry in [
            "Genre",
            "Tags",
            "Languages",
            "CountryAvailability",
            "Actors",
            "ProductionHouse",
        ]:
            array = [
                entry.strip().lower() for entry in str(row[parsable_entry]).split(",")
            ]
            row[parsable_entry] = array

        # Hidden Gem Score stays the same.

        # RuntimeCategory is changed to be two different values, in order to do
        # operations on the entire database.
        # RuntimeCategory is dropped after data processing.
        match str(row["RuntimeCategory"]):
            case "< 30 minutes":
                original_csv.loc[idx, "MinMinutes"] = 0
                original_csv.loc[idx, "MaxMinutes"] = 29
            case "30-60 mins":
                original_csv.loc[idx, "MinMinutes"] = 30
                original_csv.loc[idx, "MaxMinutes"] = 60
            case "1-2 hour":
                original_csv.loc[idx, "MinMinutes"] = 60
                original_csv.loc[idx, "MaxMinutes"] = 120
            case "> 2 hrs":
                original_csv.loc[idx, "MinMinutes"] = 121
                original_csv.loc[idx, "MaxMinutes"] = None

        # Director, Writer, ViewRating, IMDbScore, RottenTomatoesScore, MetacriticScore,
        # AwardsReceived, AwardsNominated, Boxoffice, NetflixLink, IMDbLink,
        # IMDbVotes, Image, Poster, and TMDbTrailer do not get changed.

        # Some columns are lowercased.
        for entry in ["MediaType", "TrailerSite", "Summary"]:
            row[entry] = str(row[entry]).lower()

        print(type(row["ReleaseDate"]))
        original_csv.loc[idx, "ReleaseDate"] = pd.to_datetime(row["ReleaseDate"])

        original_csv.loc[idx, "NetflixReleaseDate"] = pd.to_datetime(
            row["NetflixReleaseDate"]
        )

        break

    original_csv = original_csv.drop(columns=["RuntimeCategory"])
