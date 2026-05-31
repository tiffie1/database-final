import datetime

import pandas as pd

if __name__ == "__main__":
    original_csv = pd.read_csv("./original_data.csv")

    secondary_data = {
        "Genre": set(),
        "Tags": set(),
        "Director": set(),
        "Writer": set(),
        "Languages": set(),
        "CountryAvailability": set(),
        "Actors": set(),
        "ProductionHouse": set(),
    }

    # Remove Spaces in column names for standardization.
    original_csv = original_csv.rename(
        columns={
            "Series or Movie": "MediaType",
            "Hidden Gem Score": "HiddenGemScore",
            "Country Availability": "CountryAvailability",
            "Runtime": "RuntimeCategory",
            "View Rating": "ViewRating",
            "IMDb Score": "IMDbScore",
            "Rotten Tomatoes Score": "RottenTomatoesScore",
            "Metacritic Score": "MetacriticScore",
            "Awards Nominated For": "AwardsNominated",
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
        for parsable_entry in secondary_data.keys():
            array = [
                entry.strip().lower() for entry in str(row[parsable_entry]).split(",")
            ]

            secondary_data[parsable_entry].update(array)

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

        # Change ReleaseDate to match YYYY-MM-DD format.
        try:
            date_old = datetime.datetime.strptime(str(row["ReleaseDate"]), "%d %b %Y")

            original_csv.loc[idx, "ReleaseDate"] = (
                f"{date_old.year}-{date_old.month:02d}-{date_old.day:02d}"
            )
        except Exception:
            original_csv.loc[idx, "ReleaseDate"] = None

        # NetflixReleaseDate is already in YYYY-MM-DD format.

    # Drop unused column.
    original_csv = original_csv.drop(columns=["RuntimeCategory"])

    # Create the media table. The automatic index in the Dataframe
    # will be used as the MediaID.
    media_table = original_csv[
        [
            "Title",
            "MediaType",
            "HiddenGemScore",
            "MinMinutes",
            "MaxMinutes",
            "ViewRating",
            "IMDbScore",
            "RottenTomatoesScore",
            "MetacriticScore",
            "AwardsReceived",
            "AwardsNominated",
            "Boxoffice",
            "ReleaseDate",
            "NetflixReleaseDate",
            "Summary",
            "IMDbVotes",
        ]
    ]

    media_table = media_table.reset_index(drop=True)

    dataframe_dict = {
        "Genre": pd.DataFrame(),
        "Tags": pd.DataFrame(),
        "Director": pd.DataFrame(),
        "Writer": pd.DataFrame(),
        "Languages": pd.DataFrame(),
        "CountryAvailability": pd.DataFrame(),
        "Actors": pd.DataFrame(),
        "ProductionHouse": pd.DataFrame(),
    }

    for key in secondary_data.keys():
        dataframe_dict[key] = pd.DataFrame(secondary_data[key])

    secondary_data = {
        "Genre": set(),
        "Tags": set(),
        "Director": set(),
        "Writer": set(),
        "Languages": set(),
        "CountryAvailability": set(),
        "Actors": set(),
        "ProductionHouse": set(),
    }

    for idx, row in original_csv.iterrows():
        print(idx)
        for parsable_entry in secondary_data.keys():
            array = [
                entry.strip().lower() for entry in str(row[parsable_entry]).split(",")
            ]

            for array_entry in array:

                df = dataframe_dict[parsable_entry]

                secondary_data[parsable_entry].add(
                    (idx, df[df.iloc[:, 0] == array_entry].index[0])
                )

        if idx == 4:
            break

    # Name the entity (lookup) tables.
    genre_table = dataframe_dict["Genre"].copy()
    tag_table = dataframe_dict["Tags"].copy()
    director_table = dataframe_dict["Director"].copy()
    writer_table = dataframe_dict["Writer"].copy()
    language_table = dataframe_dict["Languages"].copy()
    country_table = dataframe_dict["CountryAvailability"].copy()
    actor_table = dataframe_dict["Actors"].copy()
    production_house_table = dataframe_dict["ProductionHouse"].copy()

    genre_table.columns = ["GenreName"]
    tag_table.columns = ["TagName"]
    director_table.columns = ["DirectorName"]
    writer_table.columns = ["WriterName"]
    language_table.columns = ["LanguageName"]
    country_table.columns = ["CountryName"]
    actor_table.columns = ["ActorName"]
    production_house_table.columns = ["ProductionHouseName"]

    # Build junction (relationship) tables.
    has_genre_table = pd.DataFrame(
        sorted(secondary_data["Genre"]), columns=["MediaID", "GenreID"]
    )
    has_tag_table = pd.DataFrame(
        sorted(secondary_data["Tags"]), columns=["MediaID", "TagID"]
    )
    directs_table = pd.DataFrame(
        sorted(secondary_data["Director"]), columns=["MediaID", "DirectorID"]
    )
    writes_table = pd.DataFrame(
        sorted(secondary_data["Writer"]), columns=["MediaID", "WriterID"]
    )
    has_language_table = pd.DataFrame(
        sorted(secondary_data["Languages"]), columns=["MediaID", "LanguageID"]
    )
    available_in_table = pd.DataFrame(
        sorted(secondary_data["CountryAvailability"]), columns=["MediaID", "CountryID"]
    )
    acts_in_table = pd.DataFrame(
        sorted(secondary_data["Actors"]), columns=["MediaID", "ActorID"]
    )
    produces_table = pd.DataFrame(
        sorted(secondary_data["ProductionHouse"]),
        columns=["MediaID", "ProductionHouseID"],
    )

    media_table.index += 1
    media_table.to_csv("media.csv", index=True, index_label="MediaID")

    genre_table.index += 1
    genre_table.to_csv("genre.csv", index=True, index_label="GenreID")

    tag_table.index += 1
    tag_table.to_csv("tag.csv", index=True, index_label="TagID")

    director_table.index += 1
    director_table.to_csv("director.csv", index=True, index_label="DirectorID")

    writer_table.index += 1
    writer_table.to_csv("writer.csv", index=True, index_label="WriterID")

    language_table.index += 1
    language_table.to_csv("language.csv", index=True, index_label="LanguageID")

    country_table.index += 1
    country_table.to_csv("country.csv", index=True, index_label="CountryID")

    actor_table.index += 1
    actor_table.to_csv("actor.csv", index=True, index_label="ActorID")

    production_house_table.index += 1
    production_house_table.to_csv(
        "production_house.csv", index=True, index_label="ProductionHouseID"
    )

    # Junction tables — IDs shifted to 1-based to match entity tables.
    for jt, name in [
        (has_genre_table, "has_genre"),
        (has_tag_table, "has_tag"),
        (directs_table, "directs"),
        (writes_table, "writes"),
        (has_language_table, "has_language"),
        (available_in_table, "available_in"),
        (acts_in_table, "acts_in"),
        (produces_table, "produces"),
    ]:
        jt["MediaID"] += 1
        jt.iloc[:, 1] += 1
        jt.to_csv(f"{name}.csv", index=False)
