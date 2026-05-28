import pandas as pd

if __name__ == "__main__":
    original_csv = pd.read_csv("./original_data.csv")

    # Remove Spaces in column names for standardization.
    original_csv.rename(
        columns={
            "Series or Movie": "MediaType",
            "Hidden Gem Score": "HiddenGemScore",
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
        }
    )

    for idx, row in original_csv.iterrows():
        # Title stays the same.

        # Genres, Languages and Tags gets parsed and turned into an array in lowercase.
        for parsable_entry in ["Genre", "Tags", "Languages"]:
            array = [
                entry.strip().lower() for entry in str(row[parsable_entry]).split(",")
            ]
            row[parsable_entry] = array

            print(row[parsable_entry])

        # Lowercase Discriminant.
        row["Series or Movie"] = str(row["Series or Movie"]).lower()

        # Hidden Gem Score stays the same.

        break
