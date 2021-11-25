noemer = 97


rekening_nummers = [
    'BE75832844265251',
    'BE05352906338775',
    'BE78793503484086',
    'BE02930902902740',
    'BE54679368522400',
    'BE79481522145939',
    'BE45238582867689',
    'BE90351463032632',
    'BE85594736411006',
    'BE43534698638801',
    'BE39862582066154',
    'BE96936741435905',
    'BE06120041275522',
    'BE42102532381041',
    'BE27643075640273',
    'BE44150090238545',
    'BE05501206942175',
    'BE38008704680572',
    'BE19295595075512',
    'BE18319809423665'
]

foutieve_nummers = []


def controleerRekeningNummer(nummer):
    teller = int(nummer[4:14])
    check_digit = int(nummer[14:])

    if teller%noemer == check_digit: return True

    return False


for nummer in rekening_nummers:
    if not controleerRekeningNummer(nummer):
        foutieve_nummers.append(nummer)


if len(foutieve_nummers) > 0:
    print("Volgende rekeningnummers waren foutief:")
    for nummer in foutieve_nummers: print(nummer)
    quit()


print ("Geen foutieve rekeningnummers gevonden!")
