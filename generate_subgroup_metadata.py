#!/usr/bin/python

import sys
import os
import csv

import os

# Need to set matplotlib to use 'Agg' so that xwindows is not active and gel images can be generated.
import matplotlib
matplotlib.use('Agg')

python_path = sys.argv[0]
app_dir = os.path.dirname(os.path.realpath(python_path))
sys.path.append(os.path.abspath(app_dir))

from CpnClassiPhyR import *

#fasta_infile = os.path.join(app_dir, 'db', 'cpndb_nuc_phytoplasma_subgroups-2018-02-05.fasta')
fasta_infile = os.path.join(app_dir, 'db', 'cpn60_UT_phytoplasma_subgroups.fasta')

# Initialize CpnClassiPhyR
CpnClassiPhyR = CpnClassiPhyR()

RFLP_digests = CpnClassiPhyR.RFLP_digests(fasta_infile)

subgroup_list = sorted(list(RFLP_digests.keys()))


subgroup_metadata_dir = os.path.join(app_dir, 'subgroup_metadata')
if not os.path.exists(subgroup_metadata_dir):
    os.makedirs(subgroup_metadata_dir)

data_dir = os.path.join(subgroup_metadata_dir, 'data')
if not os.path.exists(data_dir):
    os.makedirs(data_dir)

num_bands_outfile = os.path.join(data_dir, 'num_bands_subgroups.csv')
f = open(num_bands_outfile, 'w')
num_bands_output_file = csv.writer(f)

header = []
renzyme_list = sorted(CpnClassiPhyR.renzymes)
for renzyme in renzyme_list:
    header.append(renzyme + '_' + 'band_sizes')
    header.append(renzyme + '_' + 'num_bands')

num_bands_output_file.writerow(['cpn60 UT group', 'Strain'] + header)
subgroup_list = sorted(list(RFLP_digests.keys()))
for subgroup in subgroup_list:
    RFLP_digest = RFLP_digests[subgroup]
    phyto_strain_desc = RFLP_digest['desc']
    line = []
    for renzyme in renzyme_list:
        line.append(RFLP_digest[str((renzyme,'band_sizes'))])
        line.append(RFLP_digest[str((renzyme,'num_bands'))])

    num_bands_output_file.writerow([subgroup, phyto_strain_desc] + line)

sc_matrix_data = CpnClassiPhyR.similarity_coefficient_matrix(RFLP_digests)
f.close()

matrix_outfile = os.path.join(data_dir, 'similarity_coefficient_matrix_subgroups.csv')
f = open(matrix_outfile, 'w')
matrix_output_file = csv.writer(f)
matrix_output_file.writerow(['cpn60 UT subgroups'] + subgroup_list)

print(subgroup_list)
subgroup_sc_matrix_data = {}
for strain_x in subgroup_list:
    line = []
    line.append(strain_x)
    for strain_y in subgroup_list:
        
        print('First: {0[0]}, Second: {0[1]}'.format((strain_x,strain_y)))
        print(sc_matrix_data[str((strain_x,strain_y))])

        line.append(sc_matrix_data[str((strain_x,strain_y))]['F_value'])
        subgroup_sc_matrix_data[str((strain_x, strain_y))] = sc_matrix_data[str((strain_x,strain_y))]

    matrix_output_file.writerow(line)
f.close()

virtual_gel_image_dir = os.path.join(subgroup_metadata_dir, 'gels')
if not os.path.exists(virtual_gel_image_dir):
    os.makedirs(virtual_gel_image_dir)

subgroup_RFLP_digest_data = RFLP_digests
for subgroup_id in subgroup_list:
    subgroup_RFLP_digest = subgroup_RFLP_digest_data[subgroup_id]
    phyto_strain_desc = subgroup_RFLP_digest['desc']
    
    
    print(subgroup_id)
    print(phyto_strain_desc)
    
    
    strain_name = re.search(r'\((.+)\)', phyto_strain_desc).group(1)
    cpndb_id = phyto_strain_desc.split(' ',3)[1]
    genbank_accession_id = phyto_strain_desc.split(' ',3)[2]
    desc = phyto_strain_desc.split(' ',3)[3]
    
    subgroup_RFLP_digest['strain_name'] = strain_name
    subgroup_RFLP_digest['cpndb_id'] = cpndb_id
    subgroup_RFLP_digest['genbank_accession_id'] = genbank_accession_id
    subgroup_RFLP_digest['desc'] = desc
    
    print(strain_name)
    print(cpndb_id)
    print(genbank_accession_id)
    print(subgroup_RFLP_digest['desc'])
    
    
    xlabel = "cpn60 UT" + " " + subgroup_id + " " + "(" + strain_name + ", "  + cpndb_id + ")"
    virtual_gel_filepath = CpnClassiPhyR.draw_gel(RFLP_digests[subgroup_id],xlabel,virtual_gel_image_dir)

    subgroup_RFLP_digest['virtual_gel_filepath'] = virtual_gel_filepath

    subgroup_RFLP_digest_data[subgroup_id] = subgroup_RFLP_digest
    
    RFLP_digests[subgroup_id] = subgroup_RFLP_digest

json_dir = os.path.join(subgroup_metadata_dir, 'json')
if not os.path.exists(json_dir):
    os.makedirs(json_dir)

subgroup_RFLP_digests_infile = os.path.join(json_dir, 'subgroup_RFLP_digests.json')
subgroup_RFLP_digests_file = open(subgroup_RFLP_digests_infile, "w+")
subgroup_RFLP_digests_file.write(json.dumps(subgroup_RFLP_digest_data, indent=4))
subgroup_RFLP_digests_file.close()

subgroup_sc_matrix_infile = os.path.join(json_dir, 'subgroup_sc_matrix.json')
subgroup_sc_matrix_file = open(subgroup_sc_matrix_infile, "w+")
subgroup_sc_matrix_file.write(json.dumps(subgroup_sc_matrix_data, indent=4))
subgroup_sc_matrix_file.close()

